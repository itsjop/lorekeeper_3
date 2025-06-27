<template>
  <span>the {{ genericPropName }} vue component</span>

</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
const props = defineProps({
  character_prop: { type: String, default: '' },
  colours_prop: { type: String, default: '' },
  Auth: { type: String, default: '' },
});

// const character = ref(props.characterProp);

onMounted(() => {
  console.log('sub mounted!!!', props.colours_prop, props.character_prop);
  console.log('removeColorFormatting(props.character_prop)', removeColorFormatting(props.character_prop));
  console.log('props.Auth', props.Auth)
  // removeColorFormatting(character)
  // console.log('props.character', typeof character, character);
  // console.log(' JSON.parse(props.character)', JSON.parse(character));
});
const removeColorFormatting = (jsonString) => {
  const jayson = JSON.parse(jsonString.replace(`"colours":${props.colours_prop},`, ''));
  jayson.image.colors = props.colours_prop
  return jayson;
};
</script>
