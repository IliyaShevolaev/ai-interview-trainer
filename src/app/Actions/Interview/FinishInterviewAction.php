<?

namespace App\Actions\Interview;

use App\Models\Interview\Answer;
use App\Models\Interview\InterviewResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FinishInterviewAction
{
    private function rateParse($text)
    {
        if (preg_match('/(\d{1,2})\/10/', $text, $matches)) {
            return (int)$matches[1];
        }
        return -1;
    }

    public function handle($data)
    {
        $answers = $data['answers'];
        $ratesAi = $data['rates'];
        $questions = $data['questions'];

        $parsedRates = [];
        foreach ($ratesAi as $rate) {
            array_push($parsedRates, $this->rateParse($rate));
        }

        $avgRate = (int)(array_sum($parsedRates) / count($parsedRates));

        $answersData = [];
        $createdTime = now();
        for($i = 0; $i < count($answers); $i++) {
            array_push($answersData, [
                'answer' => $answers[$i], 
                'rate' => in_array(-1, $parsedRates) ? $avgRate : $parsedRates[$i], 
                'user_id' => Auth::id(), //unregistred fix 
                'question_id' => $questions[$i]['id'],  
                'created_at' => $createdTime,
                'updated_at' => $createdTime,
            ]);
        }

        Answer::insert($answersData);

        InterviewResult::create([
            'rate' => $avgRate,
            'interview_id' => $data['interview_id'],
            'user_id' => Auth::id(),
            'created_at' => $createdTime,
            'updated_at' => $createdTime,
        ]);
        
        return $avgRate;
    }
}