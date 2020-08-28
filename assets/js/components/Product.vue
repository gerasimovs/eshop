<template>
  <div class="card">
    <header class="card-header">
      <h1 class="card-header-title">
        {{ title }}
      </h1>
    </header>
    <div class="card-image" v-if="image">
      <figure class="image is-4by3">
        <img :src="image" :alt="title">
      </figure>
    </div>
    <div class="card-content">
      <BTag>{{ priceFormatted }}</BTag>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      id: {
        type: Number,
      },
      title: {
        type: String,
      },
      image: {
        type: String,
      },
      price: {
        type: Number,
      },

      currency: {
        type: String,
        default: 'USD',
      },
      currencyRate: {
        type: Number,
        default: 1,
      },
    },
    computed: {
      priceFormatted() {
        const totalPrice = (this.price * this.currencyRate / 100).toFixed(2);
        return `${totalPrice} ${this.currency}`;
      },
    },
  }
</script>
