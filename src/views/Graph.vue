<script setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useDataStore } from '../stores/data'
import { __ } from '../i18n'

import Error from '../components/Error.vue'
import LineGraph from '../components/LineGraph.vue';

const dataStore = useDataStore()
const { graph } = storeToRefs(dataStore)

const error = ref(false)
const loading = ref(false)

const refreshData = async () => {
    if( true === loading.value ) {
        return;
    }

    try {
        loading.value = true
        await dataStore.loadData(true);
    } catch (e) {
        console.error(e.message);
        error.value = e.message
    } finally {
        loading.value = false
    }
}

</script>

<template>
    <Error v-if="error" :error="error" /> 
    <h1>{{ __('Graph') }} <button :class="{loading: loading}" @click="refreshData">{{ __('Refresh') }}</button></h1>
    <div :class="{ loading: loading }">
        <LineGraph :data="graph" />
    </div>
</template>