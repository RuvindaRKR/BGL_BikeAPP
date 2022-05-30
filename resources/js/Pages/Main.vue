<template>
  <form @submit.prevent="submit(props.bikeid)">
    <label for="input">Input:</label>
    <input id="input" v-model="form.input"/>
    <div v-if="form.errors.input">{{ form.errors.input }}</div>
    <button type="submit" :disabled="form.processing" class="btn btn-primary">Submit</button>
    <div v-if="$page.props.bikeid">{{ $page.props.bikeid }}</div>
    <div v-if="$page.props.msg">{{ $page.props.msg }}</div>
    <div v-if="$page.props.bike">OUTPUT: ({{ $page.props.bike.placeX }},{{ $page.props.bike.placeY }} ), {{ $page.props.bike.direction }}</div>
  </form>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3"

const props = defineProps({
    bikeid: { type: Number, default: 0 },
    msg: { type: String }
});

let form = useForm({
    input: '',
});

let submit = (id) => {
    form.put('/process/' + id,  {
        onSuccess: (res) => {
        }
    })
}
</script>

