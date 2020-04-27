<template>

</template>

<script>
export default {
  watch:{
      showSystembar:function(){
          return this.$store.getters.getSystembar
      }
  }


}
</script>
