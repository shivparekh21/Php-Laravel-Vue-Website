<template>
    <div>
        <h1 align="center">GraphQL Customers</h1>

        <PCard sectioned>
            <PDataTable
                :resourceName="{singular: 'Customer', plural: 'Customers'}"
                :headings="[
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
                :hasPagination="true"
                :pagination="pagination"
            >
                <template v-slot:item="{item}">
                    <PDataTableRow>
                        <PDataTableCol>{{item.node.firstName}} {{item.node.lastName}}</PDataTableCol>
                        <PDataTableCol>{{item.node.email}}</PDataTableCol>
                        <PDataTableCol>{{item.node.addresses[0].address2}} {{item.node.addresses[0].address1}} {{item.node.addresses[0].zip}}</PDataTableCol>
                    </PDataTableRow>
                </template>
            </PDataTable>
        </PCard>
    </div>
</template>

<script>
export default {
    name: "graphQl",
    data: function (){
        return{
            customers:[],
            pageInfo:[],
            pagination: {
                hasPrevious: false,
                hasNext: false,
                onNext: this.handleNext,
                onPrevious: this.handlePrevious
            },
            after :'',
            before:'',
            params:{},
        }
    },
    mounted() {
        this.loadCustomers();
    },
    methods: {
        loadCustomers() {
            var config = {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            axios.get('/api/graphQlCustomers', { config: config, params: this.params })
                .then((res) => {
                    console.log(res.data);
                    console.log(res.data.customers);
                    console.log(res.data.pageInfo);

                    this.pagination.hasNext =res.data.pageInfo.next ;
                    this.pagination.hasPrevious =res.data.pageInfo.previous;

                    this.customers = res.data.customers;
                    this.pageInfo = res.data.pageInfo;

                    this.after = res.data.pageInfo.after;
                    this.before = res.data.pageInfo.before;

                    delete this.params.after;
                    delete this.params.before;
                })
        },
        async handleNext() {
            console.log("Next CLicked");
            this.params.after = this.after;
            this.loadCustomers();
        },
        async handlePrevious() {
            console.log("Previous CLicked");
            this.params.before = this.before;
            this.loadCustomers();
        },
    }
}
</script>

<style scoped>

</style>
