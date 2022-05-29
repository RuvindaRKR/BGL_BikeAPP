<template>
  <form @submit.prevent="submit(props.bikeid)">
    <label for="input">Input:</label>
    <input id="input" v-model="form.input"/>
    <div v-if="form.errors.input">{{ form.errors.input }}</div>
    <button type="submit" :disabled="form.processing">Submit</button>
    <div v-if="$page.props.bikeid">{{ $page.props.bikeid }}</div>
  </form>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3"

const props = defineProps({
    bikeid: { type: Number, default: 0 },
});

let form = useForm({
    input: '',
});

let submit = (id) => {
    form.put('/process2/' + id,  {
        onSuccess: (res) => {
        }
    })
}
</script>

