<script setup>
  import { ref, watchEffect } from 'vue'
  import { RouterView } from 'vue-router'
  
  import { useSettingStore } from './stores/settings'

  import Loading from './components/Loading.vue'
  import Error from './components/Error.vue'

  const settingStore = useSettingStore()

  const error   = ref(false)
  const loading = ref(true)

  watchEffect(async () => {
    try {
      await settingStore.init()
      loading.value = false
      
    } catch (e) {
      loading.value = false
      error.value = e.message
    }
  })

</script>
<template>
  <header>
    <nav>
      <RouterLink to="/">Table</RouterLink>
      <RouterLink to="/graph">Graph</RouterLink>
      <RouterLink to="/settings">Settings</RouterLink>
    </nav>
  </header>

  
  <Loading v-if="loading" />
  <Error v-else-if="error" error="error" />
  <RouterView v-else />

</template>

<style scoped>
/* CSS Here.. */
</style>
