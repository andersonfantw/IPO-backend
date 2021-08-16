<template>
  <b-container fluid class="text-warning">
    <b-row>
      <b-col>
        <h2>使用者-角色</h2>
      </b-col>
      <b-col class="text-right">
        <b-button v-b-modal.modal-user-role variant="success"
          ><i class="fas fa-edit"></i
        ></b-button>
        <b-modal id="modal-user-role" title="使用者-角色">
          <b-input-group prepend="角色名稱" class="mb-3">
            <b-form-input type="search" v-model="RoleName"></b-form-input>
            <b-button variant="success" @click="createRole">新增</b-button>
          </b-input-group>
          <b-form-checkbox-group
            v-model="SelectedRoles"
            :options="Roles"
            stacked
            size="lg"
          ></b-form-checkbox-group>
          <b-button
            v-if="SelectedRoles.length"
            variant="danger"
            @click="deleteRole"
            >刪除</b-button
          >
        </b-modal>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="UserRoles"
      :fields="UserRoleHeaders"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="UserRoleBusy"
    >
      <template
        v-for="Column in UserRoleHeaders"
        #[`cell(${Column.key})`]="data"
      >
        <b-form-checkbox
          v-if="Column.key != '用户姓名'"
          :checked="data.value.grant"
          :key="Column.id"
          @change="
            updateUserRole(
              data.value.id,
              data.value.user_id,
              data.value.role_id,
              $event
            )
          "
        >
        </b-form-checkbox>
        <span v-else :key="Column.id">{{ data.value }}</span>
      </template>
      <template #empty="scope">
        {{ scope.emptyText }}
      </template>
      <template #emptyfiltered="scope">
        {{ scope.emptyFilteredText }}
      </template>
      <template #table-busy>
        <div class="text-center text-warning">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>
    </b-table>
    <b-row>
      <b-col>
        <h2>角色-功能-權限</h2>
      </b-col>
      <b-col class="text-right">
        <b-button v-b-modal.modal-role-function-permission variant="success"
          ><i class="fas fa-edit"></i
        ></b-button>
        <b-modal id="modal-role-function-permission" title="角色-功能-權限">
          <b-input-group prepend="功能名稱" class="mb-3">
            <b-form-input type="search"></b-form-input>
            <b-button variant="success">新增</b-button>
          </b-input-group>
          <b-form-checkbox-group
            v-model="SelectedFunctions"
            :options="Functions"
            stacked
            size="lg"
          ></b-form-checkbox-group>
          <b-button v-if="SelectedFunctions.length" variant="danger"
            >刪除</b-button
          >
        </b-modal>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="RoleFunctionPermissions"
      :fields="RoleFunctionHeaders"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="RoleFunctionPermissionBusy"
      responsive
    >
      <template
        v-for="Column in RoleFunctionHeaders"
        #[`cell(${Column.key})`]="data"
      >
        <div v-if="Column.key != '功能'" :key="Column.id">
          <b-form-checkbox
            v-for="(value, propertyName) in data.value.permissions"
            :key="value.id"
            :checked="value.granted"
            @change="
              updateRoleFunctionPermission(
                data.value.id,
                data.value.role_id,
                data.value.function_id,
                value.id,
                $event
              )
            "
            inline
            >{{ propertyName }}</b-form-checkbox
          >
        </div>
        <span v-else :key="Column.id">{{ data.value }}</span>
      </template>
      <template #empty="scope">
        {{ scope.emptyText }}
      </template>
      <template #emptyfiltered="scope">
        {{ scope.emptyFilteredText }}
      </template>
      <template #table-busy>
        <div class="text-center text-warning">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>
    </b-table>
  </b-container>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      UserRoleHeaders: [],
      Roles: [],
      UserRoles: [],
      RoleFunctionHeaders: [],
      RoleFunctionPermissions: [],
      UserRoleBusy: true,
      RoleFunctionPermissionBusy: true,
      RoleName: null,
      SelectedRoles: [],
      Functions: [],
      SelectedFunctions: [],
    };
  },
  props: {
    columns: {
      type: String,
      required: true,
    },
  },
  created() {
    // this.UserRoleHeaders = JSON.parse(this.columns);
    this.loadUserRoles();
    this.loadRoleFunctionPermission();
  },
  methods: {
    createRole() {
      const self = this;
      if (self.RoleName) {
        axios
          .get(`api/Role/create`, {
            params: {
              name: self.RoleName,
            },
          })
          .then((res) => {
            console.log(res);
            // self.UserRoleHeaders = [];
            // self.UserRoles = [];
            self.UserRoleBusy = true;
            self.loadUserRoles();
            self.RoleFunctionPermissionBusy = true;
            self.loadRoleFunctionPermission();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    deleteRole() {
      const self = this;
      self.SelectedRoles.forEach((role_id) => {
        axios
          .delete(`api/Role/${role_id}`)
          .then((res) => {
            console.log(res);
            // self.UserRoles = [];
            self.UserRoleBusy = true;
            self.loadUserRoles();
            self.RoleFunctionPermissionBusy = true;
            self.loadRoleFunctionPermission();
          })
          .catch((error) => {
            console.log(error);
          });
      });
      self.SelectedRoles = [];
    },
    updateUserRole(id, user_id, role_id, grant) {
      const self = this;
      if (grant) {
        axios
          .get(`api/UserRole/create`, {
            params: {
              user_id: user_id,
              role_id: role_id,
            },
          })
          .then((res) => {
            console.log(res);
            // self.UserRoles = [];
            self.UserRoleBusy = true;
            self.loadUserRoles();
            self.RoleFunctionPermissionBusy = true;
            self.loadRoleFunctionPermission();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .delete(`api/UserRole/${id}`)
          .then((res) => {
            console.log(res);
            // self.UserRoles = [];
            self.UserRoleBusy = true;
            self.loadUserRoles();
            self.RoleFunctionPermissionBusy = true;
            self.loadRoleFunctionPermission();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    updateRoleFunctionPermission(
      id,
      role_id,
      function_id,
      permission_id,
      granted
    ) {
      const self = this;
      if (granted) {
        axios
          .get(`api/RoleFunctionPermission/create`, {
            params: {
              role_id: role_id,
              function_id: function_id,
              permission_id: permission_id,
            },
          })
          .then((res) => {
            console.log(res);
            // self.UserRoles = [];
            self.RoleFunctionPermissionBusy = true;
            self.loadRoleFunctionPermission();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    loadUserRoles() {
      const self = this;
      axios
        .post("api/UserRole/list")
        .then((res) => {
          console.log(res);
          self.Roles = res.data.Roles;
          self.UserRoleHeaders = res.data.UserRoleHeaders;
          self.UserRoles = res.data.UserRoles;
          self.UserRoleBusy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadRoleFunctionPermission() {
      const self = this;
      axios
        .post("api/RoleFunctionPermission/list")
        .then((res) => {
          console.log(res);
          self.Functions = res.data.Functions;
          self.RoleFunctionHeaders = res.data.RoleFunctionHeaders;
          self.RoleFunctionPermissions = res.data.RoleFunctionPermissions;
          self.RoleFunctionPermissionBusy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>