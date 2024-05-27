<template>
    <div>
        <PTabs
            :tabs='[
                {"id":"1","content":"Products","to":"/products"},
                {"id":"2","content":"Customers","to":"/customerHome"}
                ]'>
        </PTabs>

    </div>
</template>

<script>
    export default {
        name: "navBar"
    }
</script>

<style scoped>

</style>
