<template>
    <div>
        <h1 align="center">Customers</h1>

        <PCard sectioned>
            <PDataTable
                :resourceName="{singular: 'Customer', plural: 'Customers'}"
                :headings="[
            {
                content: 'Id',
                value: 'id',
                type: 'text',
                width: '30%'
            },
            {
                content: 'Name',
                value: 'name',
                type: 'text',
            },
            {
                content: 'Email',
                value: 'email',
                type: 'text',
            },
            {
                content: 'Address',
                value: 'address',
                type: 'text',
            },
        ]"
                :rows= 'customers'
            >
                <template v-slot:item="{item}">
                    <PDataTableRow>
                        <PDataTableCol firstColumn>{{item.id}}</PDataTableCol>
                        <PDataTableCol>{{item.first_name}} {{item.last_name}}</PDataTableCol>
                        <PDataTableCol>{{item.email}}</PDataTableCol>
                        <PDataTableCol>{{item.default_address.address2}} {{item.default_address.address1}}</PDataTableCol>
                    </PDataTableRow>
                </template>
            </PDataTable>
        </PCard>

    </div>
</template>

<script>

export default {
    name: 'new',
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
            axios.get('/api/newCustomers')
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
