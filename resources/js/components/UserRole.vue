<template>
  <div class="text-warning">
    <b-row>
      <b-col>
        <h2>使用者-角色</h2>
      </b-col>
      <b-col class="text-right">
        <b-button v-b-modal.modal-user-role variant="success"
          ><i class="fas fa-edit"></i>新增/刪除</b-button
        >
        <b-modal id="modal-user-role" title="使用者-角色">
          <b-input-group prepend="角色名稱" class="mb-3">
            <b-form-input type="search" v-model="name"></b-form-input>
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
      :fields="fields"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="busy"
    >
      <template v-for="field in fields" #[`cell(${field.key})`]="data">
        <b-form-checkbox
          v-if="field.key != '用户姓名'"
          :checked="data.value.grant"
          :key="field.id"
          @change="
            updateUserRole(
              data.value.id,
              data.value.user_id,
              data.value.role_id,
              $event
            )
          "
          switch
        >
        </b-form-checkbox>
        <span v-else :key="field.id">{{ data.value }}</span>
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
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      fields: [],
      Roles: [],
      UserRoles: [],
      busy: true,
      name: null,
      SelectedRoles: [],
    };
  },
  props: {},
  created() {
    this.loadUserRoles();
  },
  methods: {
    createRole() {
      const self = this;
      if (self.name) {
        axios
          .post(`api/Role`, {
            name: self.name,
          })
          .then((res) => {
            console.log(res);
            self.loadUserRoles();
            self.$emit("reload");
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
            self.loadUserRoles();
            self.$emit("reload");
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
            self.loadUserRoles();
            // self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .delete(`api/UserRole/${id}`)
          .then((res) => {
            console.log(res);
            self.loadUserRoles();
            // self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    loadUserRoles() {
      const self = this;
      this.busy = true;
      axios
        .post("api/UserRole/list")
        .then((res) => {
          console.log(res);
          self.Roles = res.data.Roles;
          self.fields = res.data.fields;
          self.UserRoles = res.data.UserRoles;
          self.busy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>