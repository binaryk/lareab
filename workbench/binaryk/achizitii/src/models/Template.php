<?php
namespace Binaryk\Models\Nomenclator; 
use App\Models\Sys\Tip;
class Template extends \Eloquent { 

	protected $table = 'ach_template_achizitii';

	protected $fillable = [
    'nume',
    'cod_procedura',
    'descriere_procedura',
    'tip_achizitor',
    'tip_contract',
    'tip_procedura',
    'tip_anunt',
    'plafon_maxim',
    'data_semnare_cf',
    ];

    protected static $plafon = [
       '5,000' => '5,000',
       '30,000' => '30,000',
       '100,000' => '100,000',
       '130,000' => '130,000',
       '200,000' => '200,000',
       '5,000,000' => '5,000,000',
    ];

    public static function getRecord( $id )
    {
        return self::find($id);
    }

    public static function createRecord($data )
    {
        $tip_achizitie = $data['tip_achizitie'];
        unset($data['tip_achizitie']);
        $template      = $data;
        $new_template = self::create($template);
        $achizitie_template = [ [] ];
        foreach ($tip_achizitie as $key => $tip) {
            $achizitie_template[] = [ 'id_tip_achizitie' => $tip, 'id_template' => $new_template->id];
        }
        unset($achizitie_template[0]);
        AchizitiiTemplate::insert($achizitie_template);
        // dd($achizitie_template);




        return $new_template;
    }

    public static function updateRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        return $record->update($data);
    }

    public static function deleteRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        return $record->delete();
    }

    public static function toCombobox()
    {
        return [0 => ' -- Selectaţi un template --'] + self::orderBy('id')->lists('nume', 'id');
    }

    public static function plafon(){
        return [ '0' => '- Selectați -' ] + self::$plafon;
    } 


    public function achizitii(){
        return $this->belongsToMany('Binaryk\Models\Nomenclator\TipAchizitii','ach_tip_achzitii_template', 'id_template', 'id_tip_achizitie');
    } 

}
