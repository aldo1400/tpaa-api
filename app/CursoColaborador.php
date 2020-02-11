<?php

namespace App;

use App\Http\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CursoColaborador extends Model
{
    use SoftDeletes;
    // use ImageTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cursos_colaborador';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diploma',
        'url_diploma',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the supervisor for the cargo.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }

    /**
     * Get the supervisor for the cargo.
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo('App\Curso');
    }

    public function generarArchivoDeDiploma()
    {
        if ($this->diploma) {
            if (!(Storage::disk('local')->exists($this->url_diploma))) {
                if ($this->url_diploma) {
                    $url = $this->url_diploma;
                }
                Storage::disk('local')
                        ->put($url, base64_decode($this->diploma));

                $this->update([
                    'url_diploma' => $url,
                ]);
            }
        } else {
            if ($this->url_diploma) {
                $content = Storage::get($this->url_diploma);
                if ($content) {
                    $this->update([
                        'diploma' => base64_encode($content),
                    ]);
                }
            }
        }
    }
}
