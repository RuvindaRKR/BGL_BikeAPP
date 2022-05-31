<template>
<div class="card justify-content-center m-4 p-8 border border-primary">
  <form @submit.prevent="submit(props.bikeid)">
    <div class="container mt-4 position-relative">
      <div class="position-absolute top-0 start-50 translate-middle">
        <i class="fa-solid fa-person-biking fa-2xl">BikeAPP</i>
      </div>
      
      <div class="mt-3">
        <div class="row">
          <div class="col-lg-4 mt-5 mx-auto form-floating">
            <div class="form-floating mb-3">
              <input class="form-control" id="input" placeholder="name@example.com" v-model="form.input">
              <label for="input">Enter Command</label>
              <div v-if="form.errors.input">{{ form.errors.input }}</div>
              <div v-if="$page.props.msg" style="color: red;">{{ $page.props.msg }}</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 mx-auto">
            <button type="submit" :disabled="form.processing" class="btn btn-primary">Submit</button>
            <Link href="/" class="btn btn-danger m-4">Reset</Link>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 mt-4 mx-auto">
            <div v-if="$page.props.bike">Output : ({{ $page.props.bike.placeX }},{{ $page.props.bike.placeY }} ), {{ $page.props.bike.direction }}</div>
            <div v-if="$page.props.success">{{ $page.props.success }}</div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3"
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
    bikeid: { type: Number, default: 0 },
    msg: { type: String }
});

let form = useForm({
    input: '',
});

let submit = (id) => {
    form.post('/process/' + id,  {
        onSuccess: (res) => {
        }
    })
}
</script>

