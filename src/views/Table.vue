<script setup>
    import { computed } from 'vue'
    import { storeToRefs } from 'pinia'
    import { useDataStore } from '../stores/data'
    import { useSettingStore } from '../stores/settings'

    import Date from '../components/Date.vue'

    const dataStore = useDataStore()
    const settingStore = useSettingStore()

    const { numrows, humandate, emails } = storeToRefs(settingStore)
    const { table } = storeToRefs(dataStore)

    const rows = computed(() => table.value.rows.filter((row, i) => numrows.value > i)) 
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
            <tr v-for="row in rows" :key="row.id">
                <td>
                    {{row.id}}
                </td>
                <td>
                    <a target="_blank" :href="row.url">{{ row.url }}</a>
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

    <!-- TODO: Make translatable -->
    <div class="emails-list">
        <h1>Emails</h1>
        <ul>
            <li v-for="email in emails" :key="email">
                {{ email }}
            </li>
        </ul>
    </div>
</template>

<style scoped>

    .emails-list {
        padding-top: 30px;
    }
    .emails-list ul {
        padding-left: 15px;
        list-style: disc;
        font-size: 15px;
    }

    .emails-list ul > li {
    
    
    }


    table {
        width: 100%;
    }

    table thead {
        background-color: #fff;
    }

    table th {
        font-size: 15px;
    }

    table td {
        font-size: 14px;
    }

    table tbody tr:nth-child(odd) {
        background-color: #f6f7f7;
    }
    table tbody tr:nth-child(even) {
        background-color: #fff;        
    }

    table td,
    table th {
        color: rgb(60, 67, 74);
        text-align: left;
        padding: 10px 15px;
    }
</style>