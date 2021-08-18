<template>
  <div class="text-warning">
    <b-row>
      <b-col>
        <h2>角色-菜單項</h2>
      </b-col>
      <b-col class="text-right">
        <b-button v-b-modal.modal-role-menu-item variant="success"
          ><i class="fas fa-edit"></i>新增/刪除</b-button
        >
        <b-modal id="modal-role-menu-item" title="角色-菜單項">
          <b-input-group prepend="菜單項名稱" class="mb-3">
            <b-form-input type="search" v-model="name"></b-form-input>
            <b-button variant="success" @click="createMenuItem">新增</b-button>
          </b-input-group>
          <b-form-checkbox-group
            v-model="SelectedMenuItems"
            :options="MenuItems"
            stacked
            size="lg"
          ></b-form-checkbox-group>
          <b-button
            v-if="SelectedMenuItems.length"
            variant="danger"
            @click="deleteMenuItem"
            >刪除</b-button
          >
        </b-modal>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="items"
      :fields="fields"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="busy"
    >
      <template v-for="field in fields" #[`cell(${field.key})`]="data">
        <b-form-checkbox
          v-if="field.key != '菜單項'"
          :checked="data.value.granted"
          :key="field.id"
          @change="
            update(
              data.value.id,
              data.value.role_id,
              data.value.menu_item_id,
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
      MenuItems: [],
      SelectedMenuItems: [],
      items: [],
      busy: true,
      name: null,
    };
  },
  props: {},
  created() {
    this.reload();
  },
  methods: {
    createMenuItem() {
      const self = this;
      if (self.name) {
        axios
          .post(`api/MenuItem`, {
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
    deleteMenuItem() {
      const self = this;
      self.SelectedMenuItems.forEach((menu_item_id) => {
        axios
          .delete(`api/MenuItem/${menu_item_id}`)
          .then((res) => {
            console.log(res);
            self.reload();
            self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      });
      self.SelectedMenuItems = [];
    },
    update(id, role_id, menu_item_id, granted) {
      const self = this;
      if (granted) {
        axios
          .post(`api/RoleMenuItem`, {
            role_id: role_id,
            menu_item_id: menu_item_id,
          })
          .then((res) => {
            console.log(res);
            self.reload();
            // self.$emit("reload");
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        axios
          .delete(`api/RoleMenuItem/${id}`)
          .then((res) => {
            console.log(res);
            self.reload();
            // self.$emit("reload");
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
        .post("api/RoleMenuItem/list")
        .then((res) => {
          console.log(res);
          self.MenuItems = res.data.MenuItems;
          self.fields = res.data.fields;
          self.items = res.data.items;
          self.busy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>