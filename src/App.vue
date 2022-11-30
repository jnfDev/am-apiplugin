<script setup>
  import { ref, watchEffect } from 'vue'
  import { RouterView } from 'vue-router'
  
  import { useSettingStore } from './stores/settings'
  import { useDataStore } from './stores/data'

  import Header from './components/Header.vue'
  import Loading from './components/Loading.vue'
  import Error from './components/Error.vue'

  const settingStore = useSettingStore()
  const dataStore = useDataStore()

  const error   = ref(false)
  const loading = ref(true)

  watchEffect(async () => {
    try {
      await settingStore.init()
      await dataStore.loadData()
       
    } catch (e) {
      error.value = e.message

    } finally {
      loading.value = false
    }
  })

</script>
<template>
  <Header />
  
  <main id="am-api-based-app" class="am-container">
    <Loading v-if="loading" />
    <Error v-else-if="error" error="error" />
    <RouterView v-else />
  </main>

</template>

<style scoped>
/* CSS Here.. */
</style>
