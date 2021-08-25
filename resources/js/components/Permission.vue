<template>
  <b-container fluid>
    <h1 class="text-center">權限管理</h1>
    <UserRole ref="UserRole" @reload="reloadRoleControllerPermission" />
    <RoleMenuItem ref="RoleMenuItem" />
    <RoleControllerPermission ref="RoleControllerPermission" />
  </b-container>
</template>
<script>
import UserRole from "./UserRole";
import RoleControllerPermission from "./RoleControllerPermission";
import RoleMenuItem from "./RoleMenuItem";
export default {
  components: {
    UserRole,
    RoleControllerPermission,
    RoleMenuItem,
  },
  methods: {
    reloadRoleControllerPermission() {
      this.$refs.RoleMenuItem.reload();
      this.$refs.RoleControllerPermission.reload();
    },
  },
};
</script>