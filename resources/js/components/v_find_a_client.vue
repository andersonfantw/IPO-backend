<template>
    <b-input-group :size="_component_size" @click="$emit('input', find_a_client.client_acc_id)">
        <b-input :id="_id" :size="_component_size" :list="_id+'client_list'" v-model="find_a_client.client_acc_id" @keyup="find_client" placeholder="四位數字後自動檢索"></b-input>
        <b-input :class="_showbutton?'':'rounded-right'" :size="_component_size" v-model="find_a_client.client_name" disabled></b-input>
        <datalist :id="_id+'client_list'">
            <option v-for="client in find_client_list" :key="client['client_acc_id']" :value="client['client_acc_id']">{{ client['name'] }}</option>
        </datalist>
        <b-input-group-append v-if="_showbutton">
            <b-button :size="_component_size" class="w-100" @click="add" variant="primary" :disabled="busy">
                <i class="fas fa-user-plus" variant="secondary"></i> &nbsp;新增人員
            </b-button>
        </b-input-group-append>
    </b-input-group>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props: ['value','id','size','showbutton'],
    data(){
        return {
            busy:false,
            find_client_list:[],
            find_a_client:{
                client_acc_id:'',
                name:''
            }
        }
    },
    created(){
        this.find_a_client.client_acc_id = this.value
        this.find_client()
        this.$bus.$on('busy',this.busy)
    },
    beforeDestroy(){
        this.$bus.$off("busy");
    },
    watch:{
        'find_a_client.client_acc_id': function(n){
            let arr = this.find_client_list.filter(function(i){
                return i.client_acc_id==n
            })
            if(arr.length) this.find_a_client.client_name = arr[0].name
            else this.find_a_client.client_name = ''
            // 沒有button，選定後用事件回傳
            if(!this._showbutton) this.$bus.$emit('find_a_client::client',this.find_a_client)
        }
    },
    computed:{
        // prop default
        _id(){ return this.id?this.id:'find_a_client' },
        _component_size(){ return this.size?this.size:'' },
        _showbutton(){ return !(this.showbutton=='false') }
    },
    methods:{
        add(){
            this.$bus.$emit('find_a_client::add',this.find_a_client)
        },
        find_client(){
            let _this = this
            if(this.find_a_client.client_acc_id){
                if(this.find_a_client.client_acc_id.length>3){
                    this.myPost(function(response){
                        _this.find_client_list = response
                    },{acc_no:_this.find_a_client.client_acc_id},this.url('/find/client'));
                }
            }
        }
    }
}
</script>