namespace Souii/Text;

class Common{
	public static getTemplateValue(string! template,array! data) -> string[
		return preg_replace_callback('/\{(\w+)\}/',function ($value) use(arr){
                           return empty($arr[$value[1]])?'':$arr[$value[1]];
                       },$template);
	}
}
