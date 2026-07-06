<script setup>
import Header from '@/Components/layout/Header.vue';
import { ref } from 'vue';

const message = ref('Hello Vue 3!');
const count = ref(0);

const increment = () => {
  count.value++;
};
</script>

<template>
    <Header />
  <div class="container">
    <h1>{{ message }}</h1>
    <button @click="increment">Count: {{ count }}</button>
  </div>
</template>

<style scoped>
.container {
  padding: 20px;
  text-align: center;
}
</style>