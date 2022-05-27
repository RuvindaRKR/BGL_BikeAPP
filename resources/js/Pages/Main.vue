<template>
  <form @submit.prevent="submit">
    <label for="input">Input:</label>
    <input id="input" v-model="form.input"/>
    <div v-if="$page.props.errors.input">{{ $page.props.errors.input }}</div>
    <button type="submit">Submit</button>
    <div v-if="$page.props.formData">{{ $page.props.formData }}</div>
  </form>
</template>

<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

let form = reactive({
    input: '',
});

let submit = () => {
    Inertia.post('/process', form);
} 
</script>