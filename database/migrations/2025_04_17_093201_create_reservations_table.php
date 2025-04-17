<?php

use App\Classes\Commun\ExtendBlueprint;
use App\Models\Reunion\Salle;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
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
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('motif')->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Salle::class)->constrained()->cascadeOnDelete();
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
