<?php namespace Binaryk\Models\Nomenclator; 

use App\Models\Sys\Tip;

class Template extends \Eloquent 
{ 

	protected $table = 'ach_template_achizitii';
	protected $fillable = ['*'];

    protected static $plafon = [
       '5000'     => '5.000',
       '30000'    => '30.000',
       '100000'   => '100.000',
       '130000'   => '130.000',
       '200000'   => '200.000',
       '5000000'  => '5.000.000',
    ];

    public static function removeField($field, $data)
    {
        if( array_key_exists($field, $data) )
        {
            $data[$field] = NULL;
            unset($data[$field]);
        }
        return $data;
    }

    public static function removeTipachizitiifields($data)
    {
        foreach( $items = \Binaryk\Models\Nomenclator\TipAchizitii::orderBy('id')->get() as $i => $record)
        {
            $data = self::removeField('tip_achizitii_' . $record->id, $data);
        }
        return $data;
    }

    public function Tipprocedura()
    {
        return $this->belongsTo('\Binaryk\Models\Nomenclator\TipProceduriAchizitii', 'tip_procedura');
    }

    public function Tipanunt()
    {
        return $this->belongsTo('\Binaryk\Models\Nomenclator\TipAnunturi', 'tip_anunt');
    }

    public static function getRecord($id)
    {
        $record = self::find($id);
        if($record->tip_achizitie)
        {
            $record->tip_achizitie = json_decode($record->tip_achizitie);
        }
        return $record;
    }

    protected static function createTipachizitieField($data)
    {
        $result = []; 
        foreach( $items = \Binaryk\Models\Nomenclator\TipAchizitii::orderBy('id')->get() as $i => $record)
        {
            if( array_key_exists('tip_achizitii_' . $record->id, $data) )
            {
                if($data['tip_achizitii_' . $record->id] == '1')
                {
                    $result[] = ['id' => $record->id, 'nume' => $record->nume];
                }
            }
        }
        return json_encode($result);
    }

    protected static function tipContract( $tip )
    {
        if( $tip == 12 )
        {
            return 'servicii';
        }
        if( $tip == 13)
        {
            return 'lucrari';
        }
        if( $tip == 14)
        {
            return 'furnizare';
        }
        return '-';
    }

    protected static function tipAchizitor( $tip )
    {
        if( $tip == 1 )
        {
            return 'public';
        }
        if( $tip == 2)
        {
            return 'privat';
        }
        return '-';
    }

    public static function createRecord($data )
    {
        $data['tip_achizitie'] = self::createTipachizitieField($data);
        $data                  = self::removeTipachizitiifields($data);
        if( ! $data['data_semnare_cf'] )
        {
            $data['data_semnare_cf'] = NULL;
        }
        else
        {   
            $data['data_semnare_cf'] = \Carbon\Carbon::createFromformat("m/d/Y", $data['data_semnare_cf'])->format('Y-m-d');
        }
        $data['tip_contract_'] = self::tipContract($data['tip_contract']);
        $data['tip_achizitor_'] = self::tipAchizitor($data['tip_achizitor']);
        $data['plafon_maxim'] = str_replace(',', '.', str_replace('.', '', $data['plafon_maxim']));
        self::unguard();
        return self::create($data);
    }

    public static function updateRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        $data['tip_achizitie'] = self::createTipachizitieField($data);
        $data                  = self::removeTipachizitiifields($data);
        if( ! $data['data_semnare_cf'] )
        {
            $data['data_semnare_cf'] = NULL;
        }
        else
        {   
            $data['data_semnare_cf'] = \Carbon\Carbon::createFromformat("m/d/Y", $data['data_semnare_cf'])->format('Y-m-d');
        }
        $data['tip_contract_'] = self::tipContract($data['tip_contract']);
        $data['tip_achizitor_'] = self::tipAchizitor($data['tip_achizitor']);
        $data['plafon_maxim'] = str_replace(',', '.', str_replace('.', '', $data['plafon_maxim']));
        self::unguard();
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

    public static function plafon()
    {
        return [ '0' => '- Selectați -' ] + self::$plafon;
    } 

    public function achizitii()
    {
        return $this->belongsToMany('Binaryk\Models\Nomenclator\TipAchizitii','ach_tip_achzitii_template', 'id_template', 'id_tip_achizitie');
    } 

}
