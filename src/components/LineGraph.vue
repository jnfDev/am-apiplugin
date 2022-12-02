<script setup>
import { computed } from 'vue'
import { Line } from 'vue-chartjs'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale,
} from 'chart.js'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    PointElement,
    CategoryScale
);

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
})

const chartId = "am-line-chart"
const height = 600

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false
};

const chartData = computed(() => ({
    labels: props.data.map((d) => (new Date(d.date * 1000)).toLocaleDateString()),
    datasets: [
        {
            label: "Am Graph",
            backgroundColor: "#1b336f",
            data: props.data.map((d) => d.value )
        }
    ]
}))

</script>

<template>
    <Line
        :chart-data="chartData"
        :chart-id="chartId"
        :height="height"
        :chartOptions="chartOptions"
    />
</template>