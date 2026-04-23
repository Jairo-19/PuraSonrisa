<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServiciosSeeder extends Seeder
{
    /**
     * Inserta los servicios reales de la clínica dental.
     */
    public function run(): void
    {
        Servicio::create([
            'nombre'           => 'Limpieza Dental',
            'descripcion'      => 'El servicio de limpieza dental es un procedimiento preventivo que consiste en la eliminación de placa bacteriana, sarro y manchas de los dientes. Este proceso ayuda a mantener una buena salud bucal, prevenir enfermedades periodontales y mejorar la apariencia de los dientes.',
            'precio'           => 50.00,
            'duracion_minutos' => 45,
            'activo'           => true,
        ]);

        Servicio::create([
            'nombre'           => 'Blanqueamiento Dental',
            'descripcion'      => 'El blanqueamiento dental es un procedimiento estético que tiene como objetivo aclarar el color de los dientes. Este tratamiento puede realizarse en la clínica dental o en casa, utilizando productos específicos que contienen agentes blanqueadores para eliminar manchas y decoloraciones, logrando una sonrisa más brillante y atractiva.',
            'precio'           => 150.00,
            'duracion_minutos' => 60,
            'activo'           => true,
        ]);

        Servicio::create([
            'nombre'           => 'Ortodoncia',
            'descripcion'      => 'La ortodoncia es una especialidad de la odontología que se encarga de corregir la posición de los dientes y las mandíbulas para mejorar la función masticatoria y la estética facial. Este tratamiento puede incluir el uso de brackets, alineadores transparentes u otros dispositivos para alinear los dientes y lograr una sonrisa armoniosa.',
            'precio'           => 2000.00,
            'duracion_minutos' => 90,
            'activo'           => true,
        ]);

        Servicio::create([
            'nombre'           => 'Implantes Dentales',
            'descripcion'      => 'Los implantes dentales son una solución permanente para reemplazar dientes perdidos. Consisten en un tornillo de titanio que se inserta en el hueso maxilar o mandibular, sobre el cual se coloca una corona dental para restaurar la función y estética de la sonrisa. Este procedimiento ofrece una alta tasa de éxito y mejora la calidad de vida del paciente.',
            'precio'           => 2500.00,
            'duracion_minutos' => 120,
            'activo'           => true,
        ]);

        
    }
}
