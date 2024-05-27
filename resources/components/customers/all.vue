<template>
<div>
    <h1 align="center">Customers</h1>
        <PCard sectioned="">
            <PDataTable
                :headings='[{"content":"Id","value":"id","type":"text","width":"30%"},{"content":"Name","value":"name","type":"text"},{"content":"Email","value":"email","type":"text"},{"content":"Address","value":"address","type":"text"}]'
                :rows='customers'
            />
        </PCard>

</div>
</template>

<script>

export default {
    name: 'all',
    data: function (){
        return{
            customers:[],
        }
    },
    mounted() {
        this.loadCustomers();
    },
    methods:{
        loadCustomers(){
            axios.get('/api/allCustomers')
                .then((res)=>{
                    console.log(res.data);
                this.customers = res.data;
            })
        }
    }
}
</script>

<style scoped>

</style>
