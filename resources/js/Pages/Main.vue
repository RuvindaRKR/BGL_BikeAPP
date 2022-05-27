<template>
  <form @submit.prevent="submit">
    <label for="input">Input:</label>
    <input id="input" v-model="form.input"/>
    <div v-if="form.errors.input">{{ form.errors.input }}</div>
    <button type="submit" :disabled="form.processing">Submit</button>
    <div v-if="$page.props.formData">{{ $page.props.formData }}</div>
    <!-- <div v-if="$data.input">{{ $data.input }}</div> -->
  </form>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3"

let form = useForm({
    input: '',
});

let submit = () => {
    form.post('/process', {
        onSuccess: (res) => {

        }
    })
} 
</script>