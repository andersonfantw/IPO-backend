<template>
  <b-container fluid class="text-warning">
    <b-table
      hover
      bordered
      dark
      :items="users"
      :fields="Columns"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
    >
      <template v-for="Column in Columns" #[`cell(${Column.key})`]="data">
        <b-form-checkbox
          v-if="Column.key != '用户姓名'"
          :checked="data.value.grant"
          :key="Column.id"
          @change="
            updateUserRole(data.value.user_id, data.value.role_id, $event)
          "
        >
        </b-form-checkbox>
        <span v-else :key="Column.id">{{ data.value }}</span>
      </template>
    </b-table>
  </b-container>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      Columns: [],
      roles: [],
      users: [],
      role_function_permissions: [],
    };
  },
  props: {
    columns: {
      type: String,
      required: true,
    },
  },
  created() {
    this.Columns = JSON.parse(this.columns);
    this.loadUserRoles();
  },
  methods: {
    updateUserRole(user_id, role_id, grant) {
      console.log(grant);
      const self = this;
    },
    loadUserRoles() {
      const self = this;
      axios
        .post("api/Permission/list")
        .then((res) => {
          console.log(res);
          self.roles = res.data.Roles;
          self.users = res.data.Users;
          self.role_function_permissions = res.data.RoleFunctionPermissions;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>