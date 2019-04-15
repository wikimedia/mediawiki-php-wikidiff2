#ifndef INTSET_H
#define INTSET_H

#include <algorithm>
#include <bitset>
#include <functional>
#include <type_traits>
#include <unordered_set>

#include "Wikidiff2.h"

// The UnsignedSet template class represents a set of unsigned integers.
// Internally, it uses a fixed-size bitset to store small values and falls
// back to an std::unordered_set for values that exceed the bitset size.
// The default bitset size of 512 bytes can hold values in the range [0, 4096).
template <class T = unsigned int, size_t BitSetSize = 4096>
class UnsignedSet {
	static_assert(std::is_unsigned<T>::value,
		"IntSet<> only works with unsigned integer types.");

 public:
	UnsignedSet()
		: bitset_(), set_() {}

	void clear() noexcept {
		bitset_.reset();
		set_.clear();
	}

	void erase(const T& t) {
		if (t < bitset_.size()) {
			bitset_.reset(t);
		} else {
			set_.erase(t);
		}
	}

	void insert(const T& t) {
		if (t < bitset_.size()) {
			bitset_.set(t);
		} else {
			set_.emplace(t);
		}
	}

	bool contains(const T& t) const {
		if (t < bitset_.size()) {
			return bitset_.test(t);
		}
		return set_.find(t) != set_.end();
	}

 private:
	std::bitset<BitSetSize> bitset_;
	std::unordered_set<T, std::hash<T>, std::equal_to<T>, WD2_ALLOCATOR<T> > set_;
};

using IntSet = UnsignedSet<>;

#endif  // INTSET_H
