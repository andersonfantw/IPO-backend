<template>
    <div id="client_data_update">
        <a href="javascript:;" class="hint" @click="dismissCountDown=20"><i class="fas fa-question-circle"></i></a>

        <b-alert
        :show="dismissCountDown"
        dismissible
        fade
        class="m-4"
        variant="dark"
        @dismiss-count-down="countDownChanged"
        >
            <div @click="dismissCountDown=0">
                <p>使用說明：檢視單一客戶，被通知訊息的方式(簡訊、Email、帳戶總覽訊息)的通知記錄。新增的個人通知會進入列隊等待被執行，可稍後檢視通知結果。</p>
                <p>產生簡訊的方式有：</p>
                <ol>
                    <li>中台操作駁回時，由程式自動及時送出。</li>
                    <li>使用選擇器。以選擇器選擇收件的人員時，會自動帶入帳號[client_id]、中英文姓名[name]、中文名[zh_name]、英文名[en_name]、地址[addr]、電話[phone]的參數。變數不在上列的請改用匯入方式。</li>
                    <li>在訊息中心手動發送通知訊息。</li>
                    <li>畫面中有發送中的訊息，畫面每十秒更新一次</li>
                </ol>
            </div>
        </b-alert>

        <div class="m-4">
            <b-row class="filter text-white">
                <b-col cols="6" class="mb-3">
                    <b-tabs v-model="tabIndex" class="switch_search">
                        <b-tab title="帳戶號碼" active>
                            <b-input id="client_id" v-model="filter.client_id" @keyup.enter="index" placeholder="帳戶號碼，按[ENTER]查詢"></b-input>
                        </b-tab>
                        <b-tab title="客戶姓名">
                            <b-input id="client_name" v-model="filter.name" @keyup.enter="index" placeholder="客戶姓名，按[ENTER]查詢"></b-input>
                        </b-tab>
                        <b-tab title="手機號碼">
                            <b-input id="phone" v-model="filter.phone" @keyup.enter="index" placeholder="手機號碼，按[ENTER]查詢"></b-input>
                        </b-tab>
                        <b-tab title="電子郵件">
                            <b-input id="email" v-model="filter.email" @keyup.enter="index" placeholder="電子郵件，按[ENTER]查詢"></b-input>
                        </b-tab>
                    </b-tabs>
                </b-col>
                <b-col cols="3" class="mb-3">
                    <label for="sending_period">申請時間</label>
                    <date-picker v-model="filter.created_at" type="date" @change="index" range placeholder="Select date range"></date-picker>
                </b-col>
                <b-col cols="3" class="mb-3">
                    <label for="sending_period">狀態</label>
                    <b-form-select v-model="filter.status" :options="status_options" @change="index"></b-form-select>
                </b-col>
            </b-row>

            <hr />

            <b-row no-gutters>
                <b-col cols="8">
                    <!-- <b-button class="mb-3" variant="success" v-b-modal.sms><i class="fas fa-sms"></i> 發送簡訊</b-button>
                    <b-button class="mb-3" variant="success" v-b-modal.email><i class="fas fa-envelope-open"></i> 發送郵件</b-button>
                    <b-button class="mb-3" variant="success" v-b-modal.account_overview><i class="fab fa-app-store-ios"></i> 帳戶總覽訊息</b-button> -->
                </b-col>
                <b-col cols="4">
                    <b-pagination-nav
                        v-model="pagination.current_page"
                        :number-of-pages="pagination.last_page"
                        base-url="#"
                        use-router align="right"
                    ></b-pagination-nav>
                </b-col>
            </b-row>

            <b-table
                sort-by="created_at"
                :sort-desc="true"
                class="text-white"
                :items="items"
                :fields="fields">
                <template #table-colgroup="scope">
                    <col v-for="field in scope.fields" :key="field.key" :style="{ width: field.width }">
                </template>
                <template #head(model)>
                    <b-form-select v-model="filter.model" :options="model_options" @change="index"></b-form-select>
                </template>
                <template #cell(name)="row">
                    {{ row.item.client_id }}<br />{{ row.item.name }}
                </template>
                <template #cell(model)="row">
                    {{ cate_mapping[row.item.model] }} <i class="far fa-image text-warning" v-if="row.item.image"></i>
                </template>
                <template #cell(modify)="row">
                    <div v-for="(v,k) in row.item.updating" :key="k">
                        <b-row>
                            <b-col cols="4"><b>{{k}}</b></b-col>
                            <b-col cols="8">
                                <span v-if="(((row.item.original)?(row.item.original.hasOwnProperty(k)?row.item.original[k]:''):'')==v)" class="text-gray">{{v}}</span>
                                <b v-else class="text-success">{{v}}</b>
                            </b-col>
                        </b-row>
                    </div>
                </template>
                <template #cell(created_at)="row">
                    {{ row.item.created_at }}<br /><span :class="(row.item.status=='approved')?'text-success':(row.item.status=='rejected')?'text-danger':''">{{ row.item.status }}</span>
                </template>
                <template #cell(actions)="row">
                    <b-button size="sm" variant="success" v-b-toggle.client_data_detail @click="show(row.item)">
                        <i class="far fa-eye"></i> 檢視
                    </b-button>
                    <b-button size="sm" variant="success" v-if="row.item.status=='pending'" @click="update('approved',row.item)">
                        <i class="fas fa-check"></i> 通過
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="danger" v-if="row.item.status=='pending'" v-b-modal.rejected @click="target_item=row.item">
                        <i class="fas fa-times"></i> 駁回
                    </b-button>
                </template>
            </b-table>
        </div>

        <!-- detail -->
        <b-sidebar id="client_data_detail" :title="'客戶資料修改 '+cate_mapping[target_item.model]" width="800px" backdrop shadow lazy>
            <br />
            <a href="javascript:;" class="hint text-dark" @click="dismissCountDown=20"><i class="fas fa-question-circle"></i></a>
            <b-alert
            :show="dismissCountDown"
            dismissible
            fade
            class="m-4"
            variant="dark"
            @dismiss-count-down="countDownChanged"
            >
                <div @click="dismissCountDown=0">
                    <p>使用說明：綠色文字為有更動的項目。</p>
                </div>
            </b-alert>

            <h4>基本資料</h4>
            <b-table-simple>
                <b-thead>
                    <b-tr>
                        <b-th>帳號</b-th>
                        <b-th>姓名</b-th>
                        <b-th>手機</b-th>
                        <b-th>Email</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-td>{{target_item.client_id}}</b-td>
                        <b-td>{{target_item.name}}</b-td>
                        <b-td>{{target_item.mobile}}</b-td>
                        <b-td>{{target_item.email}}</b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
            <br />
            <h4>修改內容</h4>
            <b-table-simple>
                <b-tbody>
                    <b-tr v-for="(v,k) in target_item.updating" :key="k">
                        <b-th>{{k}}</b-th>
                        <b-td>
                            <span v-if="(((target_item.original)?(target_item.original.hasOwnProperty(k)?target_item.original[k]:''):'')==v)" class="text-gray">{{v}}</span>
                            <b v-else class="text-success">{{v}}</b>
                        </b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
            <br />
            <div v-if="target_item.hasOwnProperty('images')">
                <h4>證明文件</h4>
                <div v-for="(v,k) in target_item.images" :key="k">
                    <h5>{{k}}</h5>
                    <b-img :src="v"></b-img>
                </div>
            </div>
        </b-sidebar>

        <!-- del confirm -->
        <b-modal id="rejected" title="請填寫駁回理由" @ok="update('rejected',target_item)">
            <b-form-textarea v-model="form.remark" rows="3" max-rows="6"></b-form-textarea>
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'ClientDataUpdate',
    data(){
        return {
          // alert
          dismissCountDown: 0,
          tabIndex: 0,
          model_options:[],
          status_options:[
              {value:'all', text:'狀態'},
              {value:'pending', text:'待處理 pending'},
              {value:'rejected', text:'駁回 rejected'},
              {value:'approved', text:'通過 approved'}
          ],
          fields:[
            { key: 'model', label: '資料類別', width:'120px', sortable: false },
            { key: 'id', label: 'ID', width:'50px', sortable: false },
            { key: 'name', label: '姓名', width:'130px', sortable: false },
            { key: 'modify', label: '修改內容', sortable: false },
            { key: 'created_at', label: '申請時間', width:'130px', sortable: true },
            { key: 'actions', label: '操作', width:'220px' }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              path: ''
          },
          items:[],
          target_item:{},
          form:{
              uuid:'',
              remark:'',
          },
          filter:{
              client_id: '',
              name: '',
              phone: '',
              email: '',
              created_at:[],
              status: 'pending',
              model:'all',
          },
        }
    },
    created() {
        this.index();
        this.getModelCname();
    },
    watch: {
        'pagination.current_page': function(n){
            this.index()
        }
    },
    computed:{
        cate_mapping(){
            let o={}
            this.model_options.forEach(el=>(o[el.value]=el.text))
            return o
        },
        filterByTag(){
            let a = ['client_id','name','phone','email']
            let e = a[this.tabIndex]
            let t = {client_id: '',name: '',phone: '',email: ''}
            
            t[e] = this.filter[e]
            return Object.assign({},this.filter,t)
        }
    },
    methods: {
        // alert
        countDownChanged(dismissCountDown){
            this.dismissCountDown = dismissCountDown
        },
        collapse_summary(e){
            let el = e.currentTarget
            el.setAttribute('style',(el.getAttribute('style').indexOf('nowrap') >= 0)?'white-space: initial':'white-space: nowrap; text-decoration: underline;')
        },
        getModelCname(){
            let _this=this
            this.myGet(function(response){
                _this.model_options = response
                _this.model_options.unshift({value:'all', text:'資料類別'})
            },null,this.url('model_cname'))
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                _this.items = response.data.map(function(i){
                    let obj = {}
                    i.updating = JSON.parse(i.updating)
                    i.original = JSON.parse(i.original)
                    for (const [k, v] of Object.entries(i.updating)) {
                        let obj1 = i.original??{}
                        let os = obj1.hasOwnProperty(k)?obj1[k]:''
                        // obj[k] = _this.revise(v,os)
                        if(v!=os) obj[k]=v
                    }
                    i.revise = obj
                    return i
                })

                _this.pagination.last_page = response.last_page
                _this.pagination.base_url = response.path + '?page='
            },'/'+this.$options.name+'?page='+this.pagination.current_page, this.filterByTag);
        },
        show(item){
            this.target_item=item
            let _this = this
            this.myGet(function(response){
                _this.target_item = response
                _this.target_item.updating = JSON.parse(_this.target_item.updating)
                _this.target_item.original = JSON.parse(_this.target_item.original)
            },null,this.url(this.target_item.model+'/'+this.target_item.uuid))
        },
        update(method, item){
            this.target_item=item
            let _this = this
            let formdata = this.getFormData({'method':method});
            if(method=='rejected') formdata.append('remark',this.form.remark)
            this.myPut(function(response){
                if(response.ok) _this.index()
                _this.form.remark = ''
            }, formdata,this.url(this.target_item.model+'/'+this.target_item.uuid));
        },
        revise(ns1,os2){
            let arr=[]
            let j=0, _v=ns1, _os=os2, ss=''
            do{
                j++
                ss = this.getMaxStr(_v,_os)
                arr.push(ss)
                _v = _v.replaceAll(ss,'|!'+j+'?|')
                _os = _os.replaceAll(ss,'|%'+j+'^|')
            } while(j<50 && ss!=-1)
            let av = _v.replaceAll('||','|').replaceAll('!','{').replaceAll('?','}').split('|')
            let aos = _os.replaceAll('||','|').replaceAll('%','{').replaceAll('^','}').split('|')
            let i1=0, i2=0, index=0, tmp=''
            j=0, ss=''
            do{
                tmp = av[i1].match(/\{(\d)\}/)
                if(tmp==null){
                    if(av[i1]!='') ss+='<b class="text-info">'+av[i1]+'</b>'
                    i1++
                }else if(tmp[1]==index){
                    ss+=arr[index-1]
                    i1++
                    i2++
                }else{
                    index=tmp[1]
                }
                tmp = aos[i2].match(/\{(\d)\}/)
                if(tmp==null){
                    if(aos[i2]!='') ss+=' <del class="text-danger"> '+aos[i2]+' </del> '
                    i2++
                }else if(tmp[1]==index){
                    ss+=arr[index-1]
                    i1++
                    i2++
                }else{
                    index=tmp[1]
                }
                j++
            }while(j<50 && (i1<av.length-1 && i2<aos.length-1))
            return ss
        },
        revise1(ns1,os2){
            ns1 = ns1??''
            os2 = os2??''
            ns1 = (typeof ns1!='')?ns1.toString():ns1
            os2 = (typeof os2!='')?os2.toString():os2
            let a1 = (ns1??'').split('')
            let a2 = (os2??'').split('')
            let out=''
            let j=0
            for(let i=0;i<a2.length;i++){
                if(a2[i]==a1[j]){
                    out=out+'<span>'+a2[i]+'</span>'
                    j++
                }else{
                    out=out+'<del> '+a2[i]+' </del>'
                }
            }
            out=out+'<span>'+ns1.substr(j)+'</span>'
            out = out.replaceAll('</del><del>','')
                .replaceAll('</span><span>','')
                .replaceAll('<del>',"<del class='text-danger'>")
            return out
        },
        getMaxStr(ns1,os2){
            let max=ns1.length>os2.length?ns1:os2
            let min=max==ns1?os2:ns1
            for(let i=0;i<min.length;i++){
                for(let x=0,y=min.length-i;y!=min.length+1;x++,y++){
                    let s=min.substring(x,y)
                    if(max.indexOf(s)!=-1 && s.length>1) return s
                }
            }
            return -1
        }
    }
}
</script>

<style>
/* datepicker */
.mx-input{
    height: 37px;
}
.mx-datepicker-range{
    width: 100%;
}

.hint{
    color:gray;
    float: right;
    margin: -20px 3px 0 0;
}
#notify_client summary{
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 450px;
    min-width: 250px;
}
</style>