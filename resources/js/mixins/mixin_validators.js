import SimpleVueValidator from "simple-vue-validator"
const Validator = SimpleVueValidator.Validator
const Rule = SimpleVueValidator.Rule

export default {
    mixins: [SimpleVueValidator.mixin],
    data () {
        return {
            registered_fields: [],
            validators: {},
            validation_rule: {},
            validation_messages: {},
            validation_attributes: {}
        }
    },
    created() {
        Rule.prototype.accepted = function(message){
            var value = this._checkValue()
            if (['on','true','1',true,1].indexOf(value)===-1){
                this._messages.push(message)
            }
            return this
        }
        Rule.prototype.dimensions = function(min_width,min_height,max_width,max_height,message){
            let _this = this
            var value = this._checkValue()
            if(value){
                var reader = new FileReader();
                reader.onload = function (readerEvent) {
                    var image = new Image();
                    image.onload = function (imageEvent) {
                        let oversize = false
                        if(min_width > this.width) oversize = true
                        if(max_width < this.width) oversize = true
                        if(min_height > this.height) oversize = true
                        if(max_height < this.height) oversize = true
                        if(oversize) _this._messages.push(message)
                    }
                    image.src = readerEvent.target.result;
                }
                reader.readAsDataURL(value);
            }
            return this
        }
    },
    validators: {
    },
    methods: {
        connectServerValidator(fields) {
            // method in parent create
            if(Array.isArray(fields)) this.registered_fields = this.registered_fields.concat(fields)
            else if(typeof fields =='string') this.registered_fields = this.registered_fields.concat([fields])

            let _this = this
            this.getValidations(this.registered_fields, function(response){
                _this.validation_rule = response.rule
                _this.validation_messages = response.message
                _this.validation_attributes = response.attributes

                SimpleVueValidator.extendTemplates(response.message)

                _this.$options.validators = {}
                for(const [k,v] of Object.entries(response.rule)) {
                    _this.$watch('form.'+k,function(n,o){
                        _this.$options.validators['form.'+k] = function(n, o){
                            return _this.validate(k, n, v)
                        }
                    },{
                        immediate: true
                    })
                }

                _this.$setValidators(_this.$options.validators);
                if (_this.validation) {
                    // set vm to validation
                    _this.validation._setVM(_this);
                }
            })
        },
        validate(name, value, validation) {
            this.$options.validators['form.'+name] = Validator.value(value)
            let _this = this
            let _datatype = ''
            validation.split('|').forEach(e => {
                let a = e.split(':')
                let b = ['','']
                if(['numeric','string','file','array','image'].includes(a[0]) && _datatype==='') _datatype=a[0];
                if(_datatype=='image') _datatype='file';
                if(a[1]){
                    b = a[1].split(',')
                }
                let msg = _this.validation_messages[a[0]]
                if(_this.validation_messages[name+'.'+a[0]]){
                    msg = _this.validation_messages[name+'.'+a[0]]
                }
                if(Array.isArray(msg) && msg.length>0) msg = msg[0]

                _this.add(_datatype, name,a[0],_this.validation_attributes[name],msg,b)
            })
            return this.$options.validators['form.'+name]
        },
        add(datatype, name, method,attribute, msg, parameters){
            let n = 'form.'+name
            switch(method){
                case 'numeric':
                    this.$options.validators[n].integer(msg.replace(':attribute',attribute))
                    // this.$options.validators[n].digit(msg)
                    break;
                case 'float':
                    this.$options.validators[n].float(msg.replace(':attribute',attribute))
                    break;
                case 'string':
                    break;
                case 'file':
                    break;
                case 'array':
                    break;
                case 'email':
                    this.$options.validators[n].email(msg.replace(':attribute',attribute))
                    break;
                case 'accepted':
                    this.$options.validators[n].accepted(msg.replace(':attribute',attribute))
                    break
                case 'active_url':
                case 'url':
                    this.$options.validators[n].url(msg.replace(':attribute',attribute))
                    break
                case 'required':
                    this.$options.validators[n].required(msg.replace(':attribute',attribute))
                    break
                case 'dimensions':
                    let p = {'min_width':0,'min_height':0,'max_width':3072,'max_height':3072}
                    parameters.forEach(i => {
                        let a = i.split('=')
                        p[a[0]] = a[1]
                    })
                    this.$options.validators[n].dimensions(p['min_width'],p['min_height'],p['max_width'],p['max_height'],msg.replace(':attribute',attribute))
                    break
                case 'regex':
                    this.$options.validators[n].regex(parameters[0].substr(1,parameters[0].length-2),msg.replace(':attribute',attribute))
                    break
                case 'size':
                    switch(datatype){
                        case '':
                        case 'string':
                            this.$options.validators[n].length(parseInt(parameters[0]),msg['string'].replace(':attribute',attribute).replace(':size',parameters[0]))
                            break
                        case 'numeric':
                            break
                        case 'array':
                            this.$options.validators[n].size(parseInt(parameters[0]),msg['array'].replace(':attribute',attribute).replace(':size',parameters[0]))
                            break
                    }
                    break
                case 'min':
                    switch(datatype){
                        case '':
                        case 'string':
                            this.$options.validators[n].minLength(parameters[0],msg['string'].replace(':attribute',attribute).replace(':min',parameters[0]))
                            break
                        case 'numeric':
                            this.$options.validators[n].greaterThan(parameters[0],msg['numeric'].replace(':attribute',attribute).replace(':min',parameters[0]))
                            break
                    }
                    break
                case 'max':
                    switch(datatype){
                        case '':
                        case 'string':
                            this.$options.validators[n].maxLength(parameters[0],msg['string'].replace(':attribute',attribute).replace(':max',parameters[0]))
                            break
                        case 'numeric':
                            this.$options.validators[n].lessThan(parameters[0],msg['numeric'].replace(':attribute',attribute).replace(':max',parameters[0]))
                            break
                    }
                    break
                case 'between':
                    switch(datatype){
                        case '':
                        case 'string':
                            this.$options.validators[n].minLength(parameters[0],msg['string'].replace(':attribute',attribute).replace(':min',parameters[0]))
                            this.$options.validators[n].maxLength(parameters[0],msg['string'].replace(':attribute',attribute).replace(':max',parameters[1]))
                            break
                        case 'numeric':
                            this.$options.validators[n].integer().lengthBetween(
                                parameters[0],parameters[1],
                                msg['numeric'].replace(':attribute',attribute).replace(':min',parameters[0]).replace(':max',parameters[1])
                            )
                    }
                    break
            }
        },
        getValidations (fields, successCallback, failCallback) {
            let _this = this
            axios.post('api/v1/json/client_validate.json',{
                site : 'frontend',
                page : this.$options.name,
                fields: fields
            },{
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
        serverCustomValidation (method, parameters, successCallback, failCallback){
            let url = {
                mobile: 'api/v1/valid/mobile'
            }
            let _this = this
            axios.post(url[method], parameters,{
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then( (response) => {
                successCallback(response.data.ok)
            }).catch( (err) => {
                console.error(err);
                if(failCallback) failCallback( err )
            });
        },
        setServerFailMessageToValidator (errors){
            let _this = this
            Object.entries(errors).forEach((v)=>{
                _this.validation.setError('form.'+v[0],v[1][0])
                _this.validation.firstError('form.'+v[0])
            })
        }
    }
}
