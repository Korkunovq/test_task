<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
</script>

<template>
    <div class="container mt-3">
      <router-view />
    </div>
    <notifications />
</template>

