<?php namespace Binaryk\Models\Nomenclator; 

class ModalitatiPublicare extends \Eloquent { 

	protected $table = 'ach_modalitati_publicare';

	protected $fillable = ['nume', 'id_tip_anunt', 'anunt_anterior', 'tip_complexitate', 'zile_dp'];

    protected static $anterior     = [ '1' => 'Nu', '2' => 'Da' ];
    protected static $complexitate = [ '1' => 'Redus', '2' => 'Normal/Mare' ];
    protected static $zile         = [ '1' => '4', '2' => '6','3' => '10', '4' => '36','5' => '52' ];

    public static function getRecord( $id )
    {
        $record = self::find($id);
        return $record;
    }

    public static function createRecord($data )
    {
        return self::create($data);
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
        return [0 => ' -- Selectaţi un anunț --'] + self::orderBy('id')->lists('nume', 'id');
    }

    public static function anterior()
    {
        return [0 => ' -- Selectaţi --'] + self::$anterior;
    }

    public static function complexitate()
    {
        return [0 => ' -- Selectaţi --'] + self::$complexitate;
    }

    public static function zile()
    {
        return [0 => ' -- Selectaţi --'] + self::$zile;
    }

    public function procedura(){
        return $this->belongsTo('Binaryk\Models\Nomenclator\TipProceduriAchizitii','id_tip_procedura');
    }

    public static function toTextAnterior( $value )
    {
        if( array_key_exists($value, self::$anterior) )
        {
            return self::$anterior[$value];
        }
        return '-';
    }

    public static function toTextTipComplexitate( $value )
    {
        if( array_key_exists($value, self::$complexitate) )
        {
            return self::$complexitate[$value];
        }
        return '-';
    }

    public static function toTextZileDP( $value )
    {
        if( array_key_exists($value, self::$zile) )
        {
            return self::$zile[$value];
        }
        return '-';
    }

    public static function toFormByTipAnunt($id_tip_anunt)
    {
        $tip_anunt = TipAnunturi::find( $id_tip_anunt );
        $items = self::where('id_tip_anunt', $id_tip_anunt)->orderBy('id')->get();
        return [
            'header' => 'Modalitati de publicare aferente tipului de anunt<br/>' . $tip_anunt->nume,
            'body'   => \View::make('achizitii::nomenclator.modalitati_publicare.parts.modal_body')->with(['records' => $items])->render(),
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Renunta</button>',
        ];
    } 

} 