<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationRuleParser;

trait rulesaid
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param array $field_names
     * @return array
     */
    public function rules(array $field_names): array
    {
        //從 config/validators 建立驗證
        return array_filter(
            config('validators.rule'),
            function($v, $k) use($field_names) {
                return in_array($k,$field_names);
            },
            ARRAY_FILTER_USE_BOTH);
    }

    public function mergeRules(array $result, string $attribute, array $rules)
    {
        // $ValidationRuleParser->mergeRules 字串的rule合併時無法去除重複的
        $ValidationRuleParser = new ValidationRuleParser([]);
        $keys = array_map(function($s){return str::studly($s);},array_keys($rules));

        $_rules = $ValidationRuleParser->explode($result)->rules;
        $_rules[$attribute] = array_map(function($rule) use($rules,$keys) {
            $r = ValidationRuleParser::parse($rule);
            return (in_array(str::studly($r[0]),$keys)!==false)
                ?str::lower($r[0]).':'
                    .(is_array($rules[str::lower($r[0])])
                        ?implode(',',$rules[str::lower($r[0])])
                        :$rules[str::lower($r[0])])
                :$rule;
        },$_rules[$attribute]);
        $result[$attribute] = implode('|',$_rules[$attribute]);
        return $result;
    }
}
