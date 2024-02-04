<?php

namespace App\Console\Commands;

use App\Services\QuoteService;
use Illuminate\Console\Command;
use \Symfony\Component\Console\Output\ConsoleOutput;

class FiveRandomQuotesComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:Get-FiveRandomQuotes {--new}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Five Random Quotes';

    protected $quoteService;
    

    public function __construct(QuoteService $quoteService)
    {
        parent::__construct();    
        $this->quoteService = $quoteService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = new ConsoleOutput();

        $new =  $this->option('new');
        
        $quotes = $this->quoteService->getQuotes('quotes',!$new,5);
        
        foreach ($quotes as $q){
            $quoteText =  ($q->cached == true) ? '[CACHED] '.$q->q : $q->q;
            $output->writeln('<bg=black>'."--------------------------------"."</>");
            $output->writeln('<bg=gray;fg=magenta>' . $quoteText . '</>');
            $output->writeln('<info>' .$q->a . '</info>');
        }
       
    }
}
