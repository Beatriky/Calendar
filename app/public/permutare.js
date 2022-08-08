//se da un n cu permutare care sa fie oricare dintre nr consecutive in permutare sa nu fie si in multimiea nr nat

//n=5 permutarea multimii nr 1 2 3 4 5
const permute = function (nums) {
    let result = [];
    let backtrack = (i, nums) => {
        if(i==1)
            return 1;
        if(i==2)
            return 2;
        if(i==3)
            return 3;
        if (i === nums.length) {
            result.push(nums.slice());
            return;
        }
        for (let j = i; j < nums.length; j++) {
            [nums[i], nums[j]] = [nums[j], nums[i]];
            backtrack(i + 1, nums);
            [nums[i], nums[j]] = [nums[j], nums[i]];
        }
    }
    backtrack(0, nums);
    console.log(result);
    return result;
};
permute([1,2,3,4,5,6,7,8]);

let perm = Array(3).fill(0);

perm = perm.map((item, index) => index + 1);

let perm = Array(5).fill(0);

perm = perm.map((item, index) => index + 1);

perm = [
    ...perm.filter(item => item%2 == 0),
    ...perm.filter(item => item%2 == 1)
];