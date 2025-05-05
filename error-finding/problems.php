<?php
function getProblems() {
    return [
        [
            'title' => 'ত্রুটি খুঁজুন #১ - ফ্যাক্টরিয়াল ফাংশন',
            'description' => 'এই কোডে ফ্যাক্টরিয়াল গণনা করার সময় কি সমস্যা আছে?',
            'code' => 'def factorial(n):
    result = 1
    for i in range(1, n):
        result *= i
    return result

print(factorial(5))',
            'options' => [
                'A. range(1, n) হওয়া উচিত range(n)',
                'B. range(1, n) হওয়া উচিত range(1, n+1)',
                'C. result *= i হওয়া উচিত result += i',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'B',
            'explanation' => 'সঠিক উত্তর B কারণ ফ্যাক্টরিয়ালের জন্য আমাদের 1 থেকে n পর্যন্ত গুণ করতে হবে, কিন্তু বর্তমান কোডে n-1 পর্যন্ত গুণ হচ্ছে।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #২ - গড় নির্ণয়',
            'description' => 'এই কোডে কি সিনট্যাক্স ত্রুটি আছে?',
            'code' => 'def calculate_average(numbers):
    total = 0
    for num in numbers
        total += num
    average = total / len(numbers
    return average',
            'options' => [
                'A. লুপে কোলন (:) নেই',
                'B. len(numbers বন্ধ করা হয়নি',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'C',
            'explanation' => 'সঠিক উত্তর C কারণ লুপ স্টেটমেন্টে কোলন (:) নেই এবং len(numbers এর বন্ধনী বন্ধ করা হয়নি।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৩ - ইন্ডেন্টেশন',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def check_number(num):
if num > 0:
    print("Positive")
elif num < 0:
print("Negative")
else:
    print("Zero")',
            'options' => [
                'A. if স্টেটমেন্টে ইন্ডেন্টেশন নেই',
                'B. elif ব্লকে ইন্ডেন্টেশন নেই',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'C',
            'explanation' => 'সঠিক উত্তর C কারণ ফাংশন বডি এবং elif ব্লক উভয়তেই ইন্ডেন্টেশন প্রয়োজন।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৪ - লিস্ট সামারি',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def sum_list(numbers):
    total = 0
    for i in range(len(numbers)):
        total = numbers[i]
    return total',
            'options' => [
                'A. total = numbers[i] হওয়া উচিত total += numbers[i]',
                'B. range(len(numbers)) অপ্রয়োজনীয়',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'A',
            'explanation' => 'সঠিক উত্তর A কারণ বর্তমান কোডে শুধুমাত্র শেষ এলিমেন্টটি টোটালে স্টোর হয়, যোগ করা হয় না।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৫ - প্রাইম নাম্বার চেক',
            'description' => 'এই কোডে কি লজিক্যাল ত্রুটি আছে?',
            'code' => 'def is_prime(n):
    if n <= 1:
        return False
    for i in range(2, n):
        if n % i == 0:
            return True
    return False',
            'options' => [
                'A. return True এবং return False উল্টে আছে',
                'B. range(2, n) হওয়া উচিত range(2, int(n**0.5)+1)',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'A',
            'explanation' => 'সঠিক উত্তর A কারণ যদি n, i দ্বারা বিভাজ্য হয় তাহলে এটি প্রাইম নয়, তাই False রিটার্ন করতে হবে।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৬ - স্ট্রিং রিভার্স',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def reverse_string(s):
    reversed = ""
    for i in range(len(s), 0, -1):
        reversed += s[i]
    return reversed',
            'options' => [
                'A. range(len(s), 0, -1) হওয়া উচিত range(len(s)-1, -1, -1)',
                'B. s[i] ইনডেক্স আউট অব রেঞ্জ হবে',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'C',
            'explanation' => 'সঠিক উত্তর C কারণ বর্তমান রেঞ্জে s[i] ইনডেক্স আউট অব রেঞ্জ এরর দেবে।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৭ - ডিকশনারি ভ্যালু আপডেট',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def update_dict(d, key, value):
    if key in d.keys():
        d[key] += value
    else:
        d[key] = value',
            'options' => [
                'A. d.keys() কল অপ্রয়োজনীয়',
                'B. শুধুমাত্র নিউমেরিক ভ্যালুর জন্য কাজ করবে',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'A',
            'explanation' => 'সঠিক উত্তর A কারণ if key in d: লেখাই যথেষ্ট, d.keys() কল করার প্রয়োজন নেই।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৮ - ফিবোনাচি সিকোয়েন্স',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def fibonacci(n):
    if n <= 0:
        return []
    elif n == 1:
        return [0]
    fib = [0, 1]
    for i in range(2, n+1):
        fib.append(fib[i-1] + fib[i-2])
    return fib',
            'options' => [
                'A. range(2, n+1) হওয়া উচিত range(2, n)',
                'B. n == 1 কেসে ভুল আউটপুট',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'D',
            'explanation' => 'সঠিক উত্তর D কারণ কোডটি সঠিকভাবে কাজ করবে।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #৯ - লিস্ট ফিল্টার',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def filter_even(numbers):
    evens = []
    for num in numbers:
        if num % 2 = 0:
            evens.append(num)
    return evens',
            'options' => [
                'A. if num % 2 = 0 হওয়া উচিত if num % 2 == 0',
                'B. evens লিস্ট ইনিশিয়ালাইজ করা হয়নি',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'A',
            'explanation' => 'সঠিক উত্তর A কারণ সমানতা চেক করতে == ব্যবহার করতে হবে, = অ্যাসাইনমেন্ট অপারেটর।'
        ],
        [
            'title' => 'ত্রুটি খুঁজুন #১০ - স্ট্রিং কাউন্ট',
            'description' => 'এই কোডে কি সমস্যা আছে?',
            'code' => 'def count_vowels(s):
    vowels = "aeiouAEIOU"
    count = 0
    for char in s.lower():
        if char in vowels:
            count += 1
        return count',
            'options' => [
                'A. return স্টেটমেন্ট লুপের ভিতরে আছে',
                'B. s.lower() হওয়া উচিত s.upper()',
                'C. A এবং B উভয়ই',
                'D. কোডে কোন সমস্যা নেই'
            ],
            'correct' => 'A',
            'explanation' => 'সঠিক উত্তর A কারণ return স্টেটমেন্ট লুপের ভিতরে থাকায় শুধুমাত্র প্রথম ইটারেশনেই ফাংশনটি রিটার্ন করবে।'
        ]
    ];
}

function getCurrentProblem() {
    session_start();
    
    if (!isset($_SESSION['problem_index']) || !isset($_SESSION['problem_time'])) {
        $_SESSION['problem_index'] = 0;
        $_SESSION['problem_time'] = time();
    }
    
    // Check if 20 minutes have passed
    if (time() - $_SESSION['problem_time'] > 20 * 60) {
        $_SESSION['problem_index'] = ($_SESSION['problem_index'] + 1) % count(getProblems());
        $_SESSION['problem_time'] = time();
    }
    
    $problems = getProblems();
    return $problems[$_SESSION['problem_index']];
}

// Handle AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    echo json_encode(getCurrentProblem());
    exit;
}
?>