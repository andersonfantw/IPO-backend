<template>
  <div class="text-warning">
    <b-row>
      <b-col>
        <h2>角色-功能-權限</h2>
      </b-col>
      <b-col class="text-right">
        <b-button v-b-modal.modal-role-function-permission variant="success"
          ><i class="fas fa-edit"></i>新增/刪除</b-button
        >
        <b-modal id="modal-role-function-permission" title="角色-功能-權限">
          <b-input-group prepend="功能名稱" class="mb-3">
            <b-form-input type="search" v-model="name"></b-form-input>
            <b-button variant="success" @click="createFunction">新增</b-button>
          </b-input-group>
          <b-form-checkbox-group
            v-model="SelectedFunctions"
            :options="Functions"
            stacked
            size="lg"
          ></b-form-checkbox-group>
          <b-button
            v-if="SelectedFunctions.length"
            variant="danger"
            @click="deleteFunction"
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
      :fields="fields"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="busy"
      responsive
    >
      <template v-for="field in fields" #[`cell(${field.key})`]="data">
        <div v-if="field.key != '功能'" :key="field.id">
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
      RoleFunctionPermissions: [],
      busy: true,
      Functions: [],
      SelectedFunctions: [],
      name: null,
    };
  },
  props: {},
  created() {
    this.loadRoleFunctionPermissions();
  },
  methods: {
    createFunction() {
      const self = this;
      if (self.name) {
        axios
          .get(`api/Function/create`, {
            params: {
              name: self.name,
            },
          })
          .then((res) => {
            console.log(res);
            self.loadRoleFunctionPermissions();
            self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    deleteFunction() {
      const self = this;
      self.SelectedFunctions.forEach((function_id) => {
        axios
          .delete(`api/Function/${function_id}`)
          .then((res) => {
            console.log(res);
            self.loadRoleFunctionPermissions();
            self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      });
      self.SelectedFunctions = [];
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
            self.loadRoleFunctionPermissions();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .delete(`api/RoleFunctionPermission/${id}`)
          .then((res) => {
            console.log(res);
            self.loadRoleFunctionPermissions();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    loadRoleFunctionPermissions() {
      const self = this;
      this.busy = true;
      axios
        .post("api/RoleFunctionPermission/list")
        .then((res) => {
          console.log(res);
          self.Functions = res.data.Functions;
          self.fields = res.data.fields;
          self.RoleFunctionPermissions = res.data.RoleFunctionPermissions;
          self.busy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>