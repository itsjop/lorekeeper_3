<template>
  <span></span>
</template>

<script setup>
import { onMounted } from 'vue';
const props = defineProps({
  propname: { type: String, default: '' },
});

onMounted(() => {
  console.log('sub mounted!!!');
});
const dosomething = () => {
  alert();
};
</script>
