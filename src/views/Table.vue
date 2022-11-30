<script setup>
    
    import { storeToRefs } from 'pinia'
    import { useDataStore } from '../stores/data'
    import { useSettingStore } from '../stores/settings'

    import Date from '../components/Date.vue'

    const dataStore = useDataStore()
    const settingStore = useSettingStore()

    const { numrows, humandate, emails } = storeToRefs(settingStore)
    const { table } = storeToRefs(dataStore)
</script>

<template>
    <h1>{{ table.title }}</h1>
    <table>
        <thead>
            <tr>
                <th v-for="col in table.headers" :key="col">
                    {{ col }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in table.rows" :key="row.id">
                <td>
                    {{row.id}}
                </td>
                <td>
                    {{ row.url }}
                </td>
                <td>
                    {{ row.title }}
                </td>
                <td>
                    {{ row.pageviews }}
                </td>
                <td>
                    <Date :timestamp="row.date" :humandate="humandate" />
                </td>
            </tr>
        </tbody>
    </table>

    <ul>
        <li v-for="email in emails" :key="email">
            {{ email }}
        </li>
    </ul>
</template>