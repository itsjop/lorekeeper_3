<template>
  <span>the {{ genericPropName }} vue component</span>
</template>

<script setup>
import { onMounted } from 'vue';
const props = defineProps({
  genericPropName: { type: String, default: '' },
});

onMounted(() => {
  console.log('sub mounted!!!');
});
const dosomething = () => {
  alert();
};
</script>
