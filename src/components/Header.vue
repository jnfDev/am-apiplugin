<script setup>
    import { computed } from 'vue'
    import { RouterLink } from 'vue-router';

    const logoUrl = computed(() => {        
        const { assetsUrl } = AmAdminVars;
        return `${assetsUrl}/images/logo.svg` 
    })
</script>

<template>
  <header>
    <div class="container logo">
        <span class="logo-cover">
            <img :src="logoUrl" alt="Plugin Logo">
        </span>
        <h1>Am Test Plugin</h1>
    </div>
    <nav class="container">
      <RouterLink class="tab-link" to="/">Table</RouterLink>
      <RouterLink class="tab-link" to="/graph">Graph</RouterLink>
      <RouterLink class="tab-link" to="/settings">Settings</RouterLink>
    </nav>
  </header>
</template>

<style scoped>
    .logo {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding-top: 24px;
        padding-bottom: 24px;
        border-top: 3px solid #ff982d;
    }
    .logo .logo-cover {
        display: inline-block;
        background-color: #0E1B3C;
        width: 52px;
        height: 52px;
        margin-right: 8px;
    }

    .logo .logo-cover img { 
        width: 100%;
    }

    nav {
        background-color: #fff;
    }

    nav .tab-link {
        margin-right: 30px;
        display: inline-block;
        padding: 20px 0 18px 0;
        border-bottom: 2px solid #fff;
        color: rgb(102, 102, 102);
        text-decoration: none;
    }

    nav .tab-link:hover {
        border-color: #999;        
    }

    nav .tab-link.router-link-active {
        border-color: #ff982d;
    }

</style>