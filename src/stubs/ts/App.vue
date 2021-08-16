<template>
    <div class="flex flex-col">
        <nav class="p-4">
            <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
        </nav>
        <div class="p-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script lang="ts">
    import {defineComponent} from 'vue'
    export default defineComponent({
        data: () => ({}),
        props: [],
        methods: {}
    })
</script>
