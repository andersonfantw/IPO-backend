/**
 * 統一處理遠端主機的驗證
 * 統一錯誤處理
 * url為相對路徑，自動前置 api/v1/
 */
import axios from 'axios'
export default {
  data () {
      return {
        api_prefix: process.env.MIX_BASE_PATH+'/api/',
        alert:{
            message:'',
            variant:'info'
        }
      }
  },
  computed:{
      alertVariant(){
          return this.total>0?'success':'danger';
      }
  },
  methods: {
    isAbsolutePath (url) {
      return url?(url.substr(0,1)==='/'):false
    },
    url(name,id=0,method=''){
        let u = id?id:''
        u += method?method:''
        u = u?'/'+u:u
        return (name)?this.isAbsolutePath(name)
            ?this.api_prefix+name.substr(1)+u
            :this.api_prefix+this.$options.name+(name?'/'+name:'')+u
            :this.api_prefix+this.$options.name+u
    },
    // action of CRUD
    crudIndex(successCallback, name, formdata, failCallback){
        console.log(formdata)
        this.myGet(successCallback, formdata, this.url(name), failCallback)
    },
    crudCreate(successCallback, name, failCallback){
        this.myGet(successCallback, {}, this.url(name,0,'create'), failCallback)
    },
    crudStore(successCallback, formdata, name, failCallback){
        this.myPost(successCallback, formdata, this.url(name), failCallback)
    },
    crudShow(id, successCallback, name, failCallback){
        this.myGet(successCallback, {}, this.url(name,id), failCallback)
    },
    crudEdit(id, successCallback, name, failCallback){
        this.myGet(successCallback, {}, this.url(name,id,'edit'), failCallback)
    },
    crudUpdate(id, successCallback, formdata, name, failCallback){
        this.myPut(successCallback, formdata, this.url(name,id), failCallback)
    },
    crudDestroy(id, successCallback, name, failCallback){
        this.myDelete(successCallback, this.url(name,id), failCallback)
    },
    // default post to vue name
    myPost (successCallback, formdata, url, failCallback) {
      let _this = this
        url = url??this.url('')
      axios.post(url,formdata,{
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      }).then( (response) => {
        successCallback(response.data)
      }).catch( (err) => {
        console.error(err);
        if(failCallback) failCallback( err )
      });
    },
    // default get from vue name
    myGet (successCallback, data, url, failCallback) {
        url = url??this.url('')
        axios.get(url, {params: data}
        ).then( (response) => {
            successCallback(response.data)
        }).catch( (err) => {
            console.error(err);
            if(failCallback) failCallback( err )
        });
    },
    myPut (successCallback, formdata, url, failCallback){
        url = url??this.url('')
        // formdata.append('_method','PUT')
        // axios.put, laravel can't retrieve formdata. use post work around
        axios.post(url,formdata,{
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then( (response) => {
            successCallback(response.data)
        }).catch( (err) => {
            console.error(err);
            if(failCallback) failCallback( err )
        });
    },
    myDelete (successCallback, url, failCallback){
        url = url??this.url('')
        axios.delete(url,{
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then( (response) => {
            successCallback(response.data)
        }).catch( (err) => {
            console.error(err);
            if(failCallback) failCallback( err )
        });
    },
    // formData
    getFormData(form){
        let formData = new FormData()
        let f = form?form:this.form
        for ( let k in f ) {
            formData.append(k, f[k]);
        }
        return formData
    },
    // server回傳訊息的顯示
    alertSuccess(msg){
        this.alert.message = msg
        this.alert.variant = 'success'
        alert(this.alert.message)
    },
    alertFail(msg){
        this.alert.message = msg
        this.alert.variant = 'danger'
    }
  }
}
