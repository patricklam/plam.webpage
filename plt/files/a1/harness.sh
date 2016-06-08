#!/bin/bash

rm -r output &> /dev/null
passed=0
failed=0
for adl in *.adl
do
    echo "${adl}"
    java ca.uwaterloo.ece251.ADL $adl &> /dev/null
    for output in output/*
    do
        expected=expected${output#output}

        if [ "${output:${#output}-3:3}" = "xml" ]
        then
            if `diff -b -w <(cat ${expected}|tr -d '\n') <(cat ${output}|tr -d '\n') > /dev/null`
            then
                echo "[PASSED] ${output}"
                passed=$((passed+1))
            else
                echo "[FAILED] ${output}"
                failed=$((failed+1))
            fi
        else
            if `diff -b -w ${expected} ${output} > /dev/null`
            then
                echo "[PASSED] ${output}"
                passed=$((passed+1))
            else
                echo "[FAILED] ${output}"
                failed=$((failed+1))
            fi
        fi
    done
    echo
    rm -r output
done
tests=$((passed+failed))
result=$(($passed * 100 / $tests))
# result=`echo "scale=2; 100 * $passed / ($passed+$failed)" | bc -l`
echo "Result: $passed/$tests ($result%) of test cases passed"
