<?php

use App\Classes\Commun\ExtendBlueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $schema = DB::getSchemaBuilder();
        $schema->blueprintResolver(function ($table, $callback) {
            return new ExtendBlueprint($table, $callback);
        });

        $schema->create('reservations', function (ExtendBlueprint $table) {
            $table->id();

            $table->date('date_debut');
            $table->date('date_fin');


            $table->whoAndWhen();
        });
        Bouncer::allow('salarie')->to('reservation-create');
        Bouncer::allow('salarie')->to('reservation-update');
        Bouncer::allow('salarie')->to('reservation-delete');
        Bouncer::allow('salarie')->to('reservation-retrieve');
        Bouncer::allow('admin')->to('reservation-create');
        Bouncer::allow('admin')->to('reservation-update');
        Bouncer::allow('admin')->to('reservation-delete');
        Bouncer::allow('admin')->to('reservation-retrieve');
        Bouncer::Refresh();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('reservations');
        Schema::enableForeignKeyConstraints();
    }
};
