/**
 * 統一處理遠端主機的驗證
 * 統一錯誤處理
 * url為相對路徑，自動前置 api/v1/
 */
import axios from 'axios'
export default {
  data () {
      return {
        api_prefix: 'api/v1/',
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
    url(name){
        return (name)?this.isAbsolutePath(name)
            ?this.api_prefix+name+'/'
            :this.api_prefix+this.$options.name+'/'+name
            :this.api_prefix+this.$options.name+'/'
    },
    // action of CRUD
    crudIndex(successCallback, name, formdata, failCallback){
        this.myGet(successCallback, formdata, name, failCallback)
    },
    crudCreate(successCallback, name, failCallback){
        this.myGet(successCallback, {}, name+'/create', failCallback)
    },
    crudStore(successCallback, formdata, name, failCallback){
        this.myPost(successCallback, formdata, name, failCallback)
    },
    crudShow(id, successCallback, name, failCallback){
        this.myGet(successCallback, {}, name+'/'+id, failCallback)
    },
    crudEdit(id, successCallback, name, failCallback){
        this.myGet(successCallback, {}, name+'/'+id+'/edit', failCallback)
    },
    crudUpdate(id, successCallback, formdata, name, failCallback){
        this.myPut(successCallback, formdata, name+'/'+id, failCallback)
    },
    crudDestroy(id, successCallback, name, failCallback){
        this.myDelete(successCallback, name+'/'+id, failCallback)
    },
    // default post to vue name
    myPost (successCallback, formdata, url, failCallback) {
      let _this = this
      url = url??''
      axios.post(this.isAbsolutePath(url)?this.api_prefix+url.substr(1):this.url(name)+url,formdata,{
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
    myGet (successCallback, formdata, url, failCallback) {
        url = url??''
        axios.get(this.isAbsolutePath(url)?this.api_prefix+url.substr(1):this.url(name)+url,
            {params: formdata}
        ).then( (response) => {
            successCallback(response.data)
        }).catch( (err) => {
            console.error(err);
            if(failCallback) failCallback( err )
        });
    },
    myPut (successCallback, formdata, url, failCallback){
        url = url??''
        axios.put(this.isAbsolutePath(url)?this.api_prefix+url.substr(1):this.url(name)+url,formdata,{
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
        url = url??''
        axios.delete(this.isAbsolutePath(url)?this.api_prefix+url.substr(1):this.url(name)+url,{
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
    getFormData(){
        let formData = new FormData()
        for ( let k in this.form ) {
            formData.append(k, this.form[k]);
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
        _this.alert.message = msg
        _this.alert.variant = 'danger'
    }
  }
}
