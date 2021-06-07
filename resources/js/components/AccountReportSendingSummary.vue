<template>
    <div class="m-4">
        <h1 class="text-warning text-center">年度通知書發送清單</h1>
        <b-button class="mb-3" variant="success" v-b-modal.modify @click="resetForm"><i class="fas fa-plus-circle"></i> 新增帳戶報告</b-button>
        <b-table class="text-white" :items="items" :fields="fields">
            <template #cell(data)="row">
                {{ row.value.start_date }} ~ {{ row.value.end_date }}
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" class="mr-1" @click="info(row.item, row.index, $event.target)">
                    編輯
                </b-button>
                <b-button size="sm" class="mr-1" @click="enter(row.item)">
                    進入
                </b-button>
                <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del="del" @click="form.id=row.item.id">
                    刪除
                </b-button>
            </template>
        </b-table>
        <!-- Add panel -->
        <b-modal id="modify" title="建立帳戶報告" size="lg" centered @ok="modify">
            <p class="my-4">Hello from modal!</p>
            <b-row>
                <b-col cols="12" class="my-2">
                    <label for="ipo_activity_period">選擇方案</label>
                    <b-form-select id="ipo_activity_period" v-model="form.ipo_activity_period_id" :options="ipo_activity_period_options"></b-form-select>
                </b-col>
                <b-col cols="6" class="my-2">
                    <label for="start_date">報告期間 從</label>
                    <b-form-datepicker id="start_date" v-model="form.start_date" locale="zh"></b-form-datepicker>
                </b-col>
                <b-col cols="6" class="my-2">
                    <label for="end_date">至</label>
                    <b-form-datepicker id="end_date" v-model="form.end_date" locale="zh"></b-form-datepicker>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="reportdate">編制日期</label>
                    <b-form-datepicker id="repor_tdate" v-model="form.report_make_date" locale="zh"></b-form-datepicker>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="performance_fee_date">表現費扣款日期</label>
                    <b-form-datepicker id="performance_fee_date" v-model="form.performance_fee_date" locale="zh"></b-form-datepicker>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="report">投資人報告書</label>
                    <b-form-textarea id="report" rows="10" max-rows="20" v-model="form.report"></b-form-textarea>
                </b-col>
            </b-row>
        </b-modal>
        <!-- Del panel -->
        <b-modal id="del" title="BootstrapVue" @ok="del">
            <p class="my-4">您確定要刪除 序號為{{form.id}} 的任務嗎?</p>
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name: 'AccountReportSendingSummary',
    data() {
      return {
          fields:[
            { key: 'id', label: '序號', sortable: true },
            { key: 'data', label: '報告期間', sortable: true },
            { key: 'total', label: '發送人數', sortable: true },
            { key: 'sending_progress', label: '發送進度', sortable: true },
            { key: 'success', label: '發送成功', sortable: true },
            { key: 'failure', label: '發送失敗', sortable: true },
            { key: 'actions', label: '操作' }
          ],
          items:[
            {
                id: 1,
                data:{
                    id:1,
                    ipo_activity_period_id:3,
                    start_date:'2020-09-01',
                    end_date:'2021-06-30',
                    report_make_date:'2021-06-15',
                    performance_fee_date:'2020-09-01',
                    report:'持續酷熱的天氣，令大家切身感受到「氣候暖化」已迫在眉睫。世界各地不少機構積極以「碳中和」的方案應對氣候問題，所謂碳中和就是指以節能、植林、使用100%可再生能源等方式，來抵銷碳排放量，以達至淨零排放的效果。而作為駕駛者的你，有否想過你也可以透過選用碳中和汽車產品，節省燃油、減少廢氣排放，一同為保護地球出一分力？'
                },
                total:5000,sending_progress:'750封 15%', success:'700封 90%', failure:'50封 10%'
            },
            {
                id: 2,
                data:{
                    id:2,
                    ipo_activity_period_id:3,
                    start_date:'2020-09-01',
                    end_date:'2021-06-30',
                    report_make_date:'2021-06-15',
                    performance_fee_date:'2020-09-01',
                    report:'持續酷熱的天氣，令大家切身感受到「氣候暖化」已迫在眉睫。世界各地不少機構積極以「碳中和」的方案應對氣候問題，所謂碳中和就是指以節能、植林、使用100%可再生能源等方式，來抵銷碳排放量，以達至淨零排放的效果。而作為駕駛者的你，有否想過你也可以透過選用碳中和汽車產品，節省燃油、減少廢氣排放，一同為保護地球出一分力？'
                },
                total:5000,sending_progress:'750封 15%', success:'700封 90%', failure:'50封 10%'
            }
          ],

          ipo_activity_period_options:[
              {value:1, text: '拳頭打新2019'},
              {value:2, text: '拳頭打新2020'},
              {value:3, text: '拚一手2021'},
          ],
          form:{
              id: 0,
              ipo_activity_period_id:0,
              start_date: '',
              end_date: '',
              report_make_date: '',
              report: ''
          }
      }
    },
    created() {
        this.index();
    },
    methods: {
        info(item, index, button) {
            for ( let k in this.form ) this.form[k] = item.data[k]
            this.$root.$emit('bv::show::modal', 'modify', button)
        },
        resetForm(){
            for ( let k in this.form ) this.form[k]=(['id','ipo_activity_period_id'].indexOf(k)===-1)?'':0
        },
        enter(item){
            document.location.href='/AccountReportSendingSummary/'+item.data.id
        },
        modify(){
            if(this.form.id===0) this.store()
            else this.update()
            this.index()
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                _this.items = response
            });
        },
        store(){
            let formdata = this.getFormData();
            this.crudStore(function(response){

            }, formdata);
        },
        update(){
            let formdata = this.getFormData();
            this.crudUpdate(this.form.id, function(response){

            }, formdata);
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            });
        },
    }
}
</script>

<style>
</style>