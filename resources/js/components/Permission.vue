<template>
  <b-container fluid class="text-warning">
    <h1 class="text-center">權限管理</h1>
    <UserRole ref="UserRole" @reload="reloadRoleFunctionPermission" />
    <RoleFunctionPermission ref="RoleFunctionPermission" />
  </b-container>
</template>
<script>
import UserRole from "./UserRole.vue";
import RoleFunctionPermission from "./RoleFunctionPermission.vue";
export default {
  components: {
    UserRole,
    RoleFunctionPermission,
  },
  methods: {
    reloadRoleFunctionPermission() {
      this.$refs.RoleFunctionPermission.loadRoleFunctionPermissions();
    },
  },
};
</script>