import time
from datetime import datetime, timedelta

class CodeErrorFinder:
    def __init__(self):
        self.problems = [
            {
                "title": "বাংলা বাইট - ত্রুটি খুঁজুন #১",
                "description": "এই পাইথন কোডে একটি লজিক্যাল ত্রুটি আছে যা সঠিকভাবে ফ্যাক্টরিয়াল গণনা করে না। ত্রুটিটি খুঁজে বের করুন এবং সংশোধন করুন।",
                "code": """def factorial(n):
    result = 1
    for i in range(1, n):
        result *= i
    return result

print(factorial(5))""",
                "language": "python",
                "errors": [
                    {
                        "line": 3,
                        "hint": "রেঞ্জ ফাংশনটি সঠিকভাবে সংখ্যাগুলো জেনারেট করছে না",
                        "solution": "range(1, n) হওয়া উচিত range(1, n+1)"
                    },
                    {
                        "line": 6,
                        "hint": "একটি অতিরিক্ত বন্ধনী আছে প্রিন্ট স্টেটমেন্টে",
                        "solution": "print(factorial(5)) হওয়া উচিত print(factorial(5))"
                    }
                ]
            },
            {
                "title": "বাংলা বাইট - ত্রুটি খুঁজুন #২",
                "description": "এই পাইথন কোডে সিনট্যাক্স এবং রানটাইম ত্রুটি আছে। ত্রুটিগুলো খুঁজে বের করুন।",
                "code": """def calculate_average(numbers):
    total = 0
    for num in numbers
        total += num
    average = total / len(numbers
    return average

print(calculate_average([10, 20, 30, 40]))""",
                "language": "python",
                "errors": [
                    {
                        "line": 3,
                        "hint": "লুপ স্টেটমেন্টে কোলন (:) নেই",
                        "solution": "'for num in numbers' হওয়া উচিত 'for num in numbers:'"
                    },
                    {
                        "line": 5,
                        "hint": "len(numbers ফাংশন কলের বন্ধনী বন্ধ করা হয়নি",
                        "solution": "'len(numbers' হওয়া উচিত 'len(numbers)'"
                    }
                ]
            },
            {
                "title": "বাংলা বাইট - ত্রুটি খুঁজুন #৩",
                "description": "এই জাভাস্ক্রিপ্ট কোডে টাইপ ত্রুটি আছে। সমস্যাটি সমাধান করুন।",
                "code": """function greetUser(name) {
    console.log("Hello, " + name + "! Welcome to Bangla Byte.");
}

greetUser(123);""",
                "language": "javascript",
                "errors": [
                    {
                        "line": 4,
                        "hint": "ফাংশনটি সংখ্যা ইনপুট নেয়ার জন্য ডিজাইন করা হয়নি",
                        "solution": "greetUser(123) হওয়া উচিত greetUser('123') অথবা ফাংশনটি মডিফাই করুন যাতে যেকোন টাইপ হ্যান্ডেল করতে পারে"
                    }
                ]
            },
            {
                "title": "বাংলা বাইট - ত্রুটি খুঁজুন #৪",
                "description": "এই সি++ কোডে মেমরি লিক সমস্যা আছে। ত্রুটিটি খুঁজে বের করুন।",
                "code": """#include <iostream>
using namespace std;

int main() {
    int* arr = new int[10];
    
    for (int i = 0; i < 10; i++) {
        arr[i] = i * 2;
    }
    
    for (int i = 0; i < 10; i++) {
        cout << arr[i] << " ";
    }
    
    return 0;
}""",
                "language": "cpp",
                "errors": [
                    {
                        "line": 4,
                        "hint": "ডায়নামিকভাবে অ্যালোকেট মেমরি ডিলিট করা হয়নি",
                        "solution": "return 0; এর আগে 'delete[] arr;' যোগ করুন"
                    }
                ]
            },
            {
                "title": "বাংলা বাইট - ত্রুটি খুঁজুন #৫",
                "description": "এই পাইথন কোডে ইন্ডেন্টেশন ত্রুটি আছে। সমস্যাটি সমাধান করুন।",
                "code": """def check_number(num):
if num > 0:
    print("Positive")
elif num < 0:
print("Negative")
else:
    print("Zero")

check_number(5)""",
                "language": "python",
                "errors": [
                    {
                        "line": 2,
                        "hint": "ইন্ডেন্টেশন নেই ফাংশন বডিতে",
                        "solution": "'if num > 0:' লাইনের আগে ৪ স্পেস যোগ করুন"
                    },
                    {
                        "line": 4,
                        "hint": "elif ব্লকের ইন্ডেন্টেশন নেই",
                        "solution": "'print(\"Negative\")' লাইনের আগে ৪ স্পেস যোগ করুন"
                    }
                ]
            }
        ]
        self.current_problem_index = 0
        self.problem_start_time = datetime.now()
        self.problem_duration = timedelta(minutes=20)  # 20 minutes per problem

    def get_current_problem(self):
        return self.problems[self.current_problem_index]

    def rotate_problem(self):
        self.current_problem_index = (self.current_problem_index + 1) % len(self.problems)
        self.problem_start_time = datetime.now()
        return self.get_current_problem()

    def check_time_elapsed(self):
        return datetime.now() - self.problem_start_time >= self.problem_duration

    def display_problem(self, problem):
        print(f"\n{problem['title']}")
        print(f"\nবর্ণনা: {problem['description']}")
        print(f"\nকোড ({problem['language']}):\n")
        print(problem['code'])
        print("\nত্রুটিগুলো খুঁজে বের করুন এবং সংশোধন করুন!")
        print(f"\nপরবর্তী সমস্যা দেখানো হবে: {(self.problem_start_time + self.problem_duration).strftime('%H:%M:%S')}")

    def display_solution(self, problem):
        print("\nসমাধান:")
        for error in problem['errors']:
            print(f"\nলাইন {error['line']}:")
            print(f"ইঙ্গিত: {error['hint']}")
            print(f"সমাধান: {error['solution']}")

    def run(self):
        print("বাংলা বাইট কোড ত্রুটি খুঁজুন ফিচারে স্বাগতম!")
        print("প্রতি ২০ মিনিট পর একটি নতুন সমস্যা দেখানো হবে।\n")
        
        while True:
            problem = self.get_current_problem()
            self.display_problem(problem)
            
            # Wait for 20 minutes or user input to show solution
            start_wait = datetime.now()
            while (datetime.now() - start_wait) < self.problem_duration:
                user_input = input("\nসমাধান দেখতে 's' টিপুন, বা প্রস্থান করতে 'q' টিপুন: ").lower()
                if user_input == 's':
                    self.display_solution(problem)
                elif user_input == 'q':
                    print("ধন্যবাদ! বাংলা বাইট ব্যবহার করার জন্য।")
                    return
            
            # Time elapsed, rotate to next problem
            print("\n২০ মিনিট পার হয়েছে! একটি নতুন সমস্যা দেখানো হচ্ছে...")
            self.rotate_problem()

if __name__ == "__main__":
    error_finder = CodeErrorFinder()
    error_finder.run()