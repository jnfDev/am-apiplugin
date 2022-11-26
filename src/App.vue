<script setup>
  import { RouterView } from 'vue-router';
</script>
<template>
  <header>
    <nav>
      <RouterLink to="/">Table</RouterLink>
      <RouterLink to="/graph">Graph</RouterLink>
      <RouterLink to="/settings">Settings</RouterLink>
    </nav>
  </header>

  <main>
    <RouterView />
  </main>

</template>

<style scoped>
/* CSS Here.. */
</style>
