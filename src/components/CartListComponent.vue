<template>
          <div  class="row rounded-borders" style="box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
            <div class="col-1 content-center">
              <div class="row justify-center">
                <q-checkbox
                  v-model="check"
                  :val="props.id"
                />
              </div>
            </div>

            <div class="col-3">
              <div class="q-pa-md">
                <q-img :src="imageSRC + props.image" ratio="1" />
              </div>
            </div>

            <div class="col-3 content-center">
              <div class="row items-center justify-center">
                {{props.title}}
              </div>
            </div>

            <div class="col-2 content-center q-gutter-y-sm q-mx-md">

              <b>Quantity</b>
              <div>
                <q-input debounce="500" v-model="quantity" outlined dense type="number"  />
              </div>
              <div>
                Rp.
                <span>{{props.price}}</span>
              </div>
            </div>

            <div class="col-2 content-center">
              <div class="q-ml-md" >
                Rp.
                <span>{{props.totalPrice}}</span>
              </div>
            </div>

          </div>
</template>
<script setup>
import { ref, watch } from 'vue'
import { api } from 'src/boot/axios.js'

const imageSRC = 'http://localhost:8080/uploads/images/'

const props = defineProps({
  title: String,
  image: String,
  quantity: String,
  price: Number,
  id: String,
  totalPrice: Number

})

const emits = defineEmits([
  'fetchData',
  'checkBoxData'
])

const check = ref([])
const quantity = ref(props.quantity)

watch(() => quantity.value, (newVal) => {
  api.put('updateCartMemberData', {
    quantity: newVal,
    id: props.id
  }).then((response) => {
    emits('fetchData')
  })
})

watch(() => check.value, (newVal) => {
  let tempValue = { value: check.value[0], status: null }
  check.value[0] === undefined
    ? tempValue = { ...tempValue, status: false }
    : tempValue = { ...tempValue, status: true }

  emits('checkBoxData', tempValue)
  // console.log(check.value[0])
})

</script>
