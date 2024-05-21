<template>
  <div class="bg-white flex justify-center items-center" style="width: 100%; position: sticky; bottom: 0; min-height: 20vh; border-radius: 8px 8px 0 0; box-shadow: 7px 7px 26px #e6e6e6, 7px -7px 26px #ffffff;">
    <div class=" q-mx-xl row" style="height: 75%; width: 100%;">
      <div class="col-6">
        <!-- kosong -->
      </div>
      <div class="col-6">
        <div class="row" >
          <div class="text-h5 q-mr-lg">Grand Total</div>
          <div class="row ">
            <div class="text-h5">Rp {{props.totalPrice}}</div>
          </div>
        </div>
        <div class="row q-mt-md ">
          <q-btn color="blue" class="q-mr-lg" @click="btnShopping">Continue Shopping</q-btn>
          <q-btn color="green" @click="btnCheckout" >Checkout</q-btn>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, watch } from 'vue'
import { api } from 'src/boot/axios.js'
import { useRouter } from 'vue-router'

const router = useRouter()
const props = defineProps({
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

const btnShopping = () => {
  router.push({ name: 'ProductPage' })
}
const btnCheckout = () => {
  router.push({ name: 'CheckoutPage' })
}

</script>
