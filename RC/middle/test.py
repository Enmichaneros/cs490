#!/usr/bin/env python
def vowelCount(text):
	count = 0
	vowel = [ "a", "e", "i", "o", "u" ]
	for c in text:
		if c.lower() in vowel:
			count = count + 1
	return count
beatleLine = "I am the walrus"
print(vowelCount(beatleLine))