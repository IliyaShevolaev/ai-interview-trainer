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

        $userId = Auth::id();
        $userId = $userId ? $userId : -1;

        $createdTime = now();

        $interviewResult = InterviewResult::create([
            'rate' => $avgRate,
            'interview_id' => $data['interview_id'],
            'user_id' => $userId,
            'created_at' => $createdTime,
            'updated_at' => $createdTime,
        ]);

        if ($interviewResult) {
            $answersData = [];
            for ($i = 0; $i < count($answers); $i++) {
                array_push($answersData, [
                    'answer' => $answers[$i],
                    'rate' => in_array(-1, $parsedRates) ? $avgRate : $parsedRates[$i],
                    'user_id' => $userId, 
                    'question_id' => $questions[$i]['id'],
                    'interview_result_id' => $interviewResult->id,
                    'created_at' => $createdTime,
                    'updated_at' => $createdTime,
                ]);
            }

            Answer::insert($answersData);
        } else {
            return -1;
        }

        return $avgRate;
    }
}
