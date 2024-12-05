<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::factory(10)->create()->each(function ($invoice) {
            $total = 0;
            InvoiceDetail::factory(5)->create(['invoice_id' => $invoice->id])->each(function ($detail) use (&$total) {
            $total += $detail->total;
            });
            $invoice->update(['total_amount' => $total]);
        });
    }
}
