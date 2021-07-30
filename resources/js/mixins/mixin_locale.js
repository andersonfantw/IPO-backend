/**
 * 語系設定mixin
 * 取得語系檔後，發出locale-ready事件。
 * created(): this.$bus.$on('locale-ready',(o)=>this.locale_ready(o))
 *
 * load():
 * 將此mixin至component中，語系自動抓../lang/(component name).json
 * 語系抓取<html lang="zh-hk">中的設定。
 * 若語系不存在自動設定為 defaultLag 的語系。
 * 若語系檔中未設定 defaultLag 時，拋出錯誤訊息。
 *
 * loadJson(url):
 * 可用此方法呼叫遠端主機的語系檔，主機位置在呼叫時傳入。
 * 語系的選擇方法與load()相同。
 * 此方法呼叫的語系檔，會與load()的語系檔合併。
 */
import axios from 'axios';
export default {
    data() {
        return {
            locale: {},
            defaultLag: 'zh-hk'
        }
    },
    created () {
        this.load(this.$options.name)
    },
    methods: {
        chooseLang(arr, l, file) {
            if(arr[l]){
                return arr[l]
            }else if(arr[this.defaultLag]){
                return arr[this.defaultLag]
            }else{
                console.error(file+' missing default language('+this.defaultLag+')')
            }
        },
        load(file) {
            import("../lang/" + file + ".json").then(lang => {
                this.locale = this.chooseLang(lang, document.documentElement.lang, file)
                this.$bus.$emit('locale-ready',this.locale)
            })
        },
        loadJson(url) {
            let _this = this
            axios.get(url)
                .then(res => {
                    _this.locale = _this.locale.concat(_this.chooseLang(res.data, document.documentElement.lang, url))
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
