<template>
<div>
    <PCard>
        <PTabs
            :tabs='[{"id":"all","content":"All","external":false},
            {"id":"new","content":"New","external":false},
            {"id":"graphQl","content":"GraphQl","external":false}]'
            @select="tab"
        >
        </PTabs>
    </PCard>

    <div>
        <p v-if="selectedTabIndex===0">
            <allCustomer></allCustomer>
        </p>
        <p v-else-if="selectedTabIndex===1">
            <newCustomer></newCustomer>
        </p>
        <p v-else-if="selectedTabIndex===2">
            <graphCustomer></graphCustomer>
        </p>
    </div>
</div>
</template>

<script>
import allCustomer from '../customers/all';
import newCustomer from '../customers/new';
import graphCustomer from '../customers/graphQl'
export default {
    name: "home",
    data: function (){
        return{
            selectedTabIndex : 0,
        }
    },
    components:{
        allCustomer,newCustomer,graphCustomer
    },

    methods:{
        tab(tabId){
            console.log(tabId);
            this.selectedTabIndex=tabId
        }
    }
}
</script>

<style scoped>

</style>
