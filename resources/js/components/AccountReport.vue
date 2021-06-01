<template>
    <div class="m-4">
        <h1 class="text-warning text-center">年度通知書發送清單</h1>
        <b-row class="filter text-white">
            <b-col cols="4" class="mb-3">
                <label for="sending_status">發送狀態</label>
                <b-form-select id="sending_status" :options="status_options"></b-form-select>
            </b-col>
            <b-col cols="4">
                <label for="account_no">帳戶號碼</label>
                <b-input id="account_no"></b-input>
            </b-col>
            <b-col cols="4">
                <label for="client_name">客戶姓名</label>
                <b-input id="client_name"></b-input>
            </b-col>
        </b-row>
        <b-table class="text-white" :items="items" :fields="fields">
            <template #cell(data)="row">
                {{ row.value.start_date }} ~ {{ row.value.end_date }}
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" class="mr-1" @click="show_html(row.item)">
                    查看報告書
                </b-button>
                <b-button size="sm" class="mr-1" @click="show_pdf(row.item)">
                    查看寄出的報告書
                </b-button>
                <b-button size="sm" class="mr-1" @click="send_test_mail(row.item)">
                    測試發送
                </b-button>
                <b-button size="sm" class="mr-1" variant="success" @click="resend(row.item)">
                    重新發送
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    props:['ipo_activity_period_id'],
    data() {
      return {
          status_options:[
              {value:'all', text:'全部'},
              {value:'pending', text:'排程中'},
              {value:'success', text:'發送成功'},
              {value:'fail', text:'發送失敗'}
          ],
          fields:[
              { key: 'name', label: '客戶姓名', sortable: true },
              { key: 'email', label: 'Email', sortable: true },
              { key: 'status', label: '發送狀態', sortable: true },
              { key: 'sending_time', label: '寄出時間', sortable: true },
              { key: 'actions', label: '操作' }
          ],
          items:[
              { account_no:'12345678',name:'FAN KUN HUA', email:'andersonfantw@gmail.com', status:'pending', sending_time:'' }
          ]
      }
    },
    methods: {
        show_html(item) {
            window.open('/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/ShowHtml/'+item.account_no)
        },
        show_pdf(item) {

        },
        resend(item) {

        },
        send_test_mail(item) {

        }
    }
}
</script>

<style>
</style>