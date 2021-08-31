<template>
  <div class="text-warning">
    <b-row>
      <b-col>
        <h2>角色-功能-權限</h2>
      </b-col>
      <b-col class="text-right">
        <b-button
          v-b-modal.modal-role-controller-permission
          variant="success"
        ><i class="fas fa-edit"></i>新增/刪除</b-button>
        <b-modal
          id="modal-role-controller-permission"
          title="角色-功能-權限"
        >
          <b-input-group
            prepend="功能名稱"
            class="mb-3"
          >
            <b-form-input
              type="search"
              v-model="name"
            ></b-form-input>
            <b-button
              variant="success"
              @click="createController"
            >新增</b-button>
          </b-input-group>
          <b-form-checkbox-group
            v-model="SelectedControllers"
            :options="Controllers"
            stacked
            size="lg"
          ></b-form-checkbox-group>
          <b-button
            v-if="SelectedControllers.length"
            variant="danger"
            @click="deleteController"
          >刪除</b-button>
        </b-modal>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="RoleControllerPermissions"
      :fields="fields"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="busy"
      responsive
    >
      <template
        v-for="field in fields"
        #[`cell(${field.key})`]="data"
      >
        <div
          v-if="field.key != '功能'"
          :key="field.id"
        >
          <b-form-checkbox
            v-for="(value, propertyName) in data.value.permissions"
            :key="value.id"
            :checked="value.granted"
            @change="
              updateRoleControllerPermission(
                data.value.id,
                data.value.role_id,
                data.value.controller_id,
                value.id,
                $event
              )
            "
            inline
            switch
          >{{ propertyName }}</b-form-checkbox>
        </div>
        <span
          v-else
          :key="field.id"
        >{{ data.value }}</span>
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
      RoleControllerPermissions: [],
      busy: true,
      Controllers: [],
      SelectedControllers: [],
      name: null,
    };
  },
  props: {},
  created() {
    this.reload();
  },
  methods: {
    createController() {
      const self = this;
      if (self.name) {
        axios
          .post(`Controller`, {
            name: self.name,
          })
          .then((res) => {
            console.log(res);
            self.reload();
            self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    deleteController() {
      const self = this;
      self.SelectedControllers.forEach((controller_id) => {
        axios
          .delete(`Controller/${controller_id}`)
          .then((res) => {
            console.log(res);
            self.reload();
            self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      });
      self.SelectedControllers = [];
    },
    updateRoleControllerPermission(
      id,
      role_id,
      controller_id,
      permission_id,
      granted
    ) {
      const self = this;
      if (granted) {
        axios
          .post(`RoleControllerPermission`, {
            role_id: role_id,
            controller_id: controller_id,
            permission_id: permission_id,
          })
          .then((res) => {
            console.log(res);
            self.reload();
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .delete(`RoleControllerPermission/${id}`)
          .then((res) => {
            console.log(res);
            self.reload();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    reload() {
      const self = this;
      this.busy = true;
      axios
        .get("RoleControllerPermission")
        .then((res) => {
          console.log(res);
          self.Controllers = res.data.Controllers;
          self.fields = res.data.fields;
          self.RoleControllerPermissions = res.data.RoleControllerPermissions;
          self.busy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>